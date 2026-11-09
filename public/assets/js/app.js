/* Archives – démonstration front-end. Données fictives, non persistantes. */
(() => {
'use strict';
const $ = (s, r = document) => r.querySelector(s), $$ = (s, r = document) => [...r.querySelectorAll(s)];
const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const fmt = v => /^\d{4}-\d{2}-\d{2}$/.test(v) ? new Date(v + 'T00:00:00').toLocaleDateString('fr-FR') : v;
const body = document.body, mq = matchMedia('(max-width:991.98px)');

/* ---------- Données de démonstration ---------- */
const D = ['Ressources humaines','Finance','Juridique','Technique','Communication','Logistique'];
const T = ['Contrat','Facture','Courrier','Rapport','Procès-verbal','Note interne'];
const S = ['Actif','En attente','Archivé','Expiré'];
const TT = ['Contrat de maintenance','Facture fournisseur','Courrier ministériel','Rapport annuel','Procès-verbal de réunion','Note de service','Marché public','Convention de partenariat'];
const SRC = ['Direction générale','Fournisseur Atlas',"Ministère de l'Intérieur",'Cabinet Idrissi','Commune de Rabat'];
const day = n => new Date(Date.UTC(2026, 0, 3 + n * 9)).toISOString().slice(0, 10);
const LOC = Array.from({length:10}, (_, i) => ({id:i+1, building:i<5?'Bâtiment A':'Bâtiment B', floor:`Étage ${i%3}`, room:`Salle ${101+i%4}`, cabinet:`Armoire ${String.fromCharCode(65+i%5)}`, shelf:`Étagère ${i%4+1}`, box:`Boîte ${10+i}`, status:i===9?'Inactif':'Actif'}));
const ARCH = Array.from({length:26}, (_, i) => ({id:i+1, number:`ARC-2026-${String(i+1).padStart(4,'0')}`, title:`${TT[i%8]} n° ${100+i}`, type:T[i%6], sender:SRC[i%5], department:D[(i*5)%6], status:S[(i*3)%4], date:day(i), expiry:day(i+40), subject:'Dossier de démonstration', notes:'Données fictives, non persistantes.', location:i%10+1, deleted:i%9===8, deletedAt:i%9===8?'2026-10-05':''}));
const NAMES = ['Sara Benali','Youssef El Amrani','Nadia Chraibi','Karim Tazi','Imane Ouazzani','Omar Alaoui','Salma Berrada','Hamza Fassi','Lina Kettani','Mehdi Squalli'];
const USERS = NAMES.map((n, i) => ({id:i+1, name:n, email:n.toLowerCase().replace(/ /g,'.')+'@archives.example', role:['Administrateur','Archiviste','Lecteur'][i%3], department:D[i%6], status:i%7===6?'Inactif':'Actif'}));
const DEPS = D.map((n, i) => ({id:i+1, code:['RH','FIN','JUR','TEC','COM','LOG'][i], name:n, description:`Service ${n.toLowerCase()}`, users:USERS.filter(u => u.department===n).length, status:'Actif'}));
const ACTS = ['Connexion','Création','Modification','Suppression','Restauration','Export'];
const LOGS = Array.from({length:30}, (_, i) => ({id:i+1, date:`2026-10-${String(12-i%12).padStart(2,'0')} ${String(8+i%10).padStart(2,'0')}:${String(i*7%60).padStart(2,'0')}`, user:NAMES[i%4], action:ACTS[i%6], record:ARCH[i%26].number, ip:`10.0.0.${10+i}`}));
const DB = {archives:ARCH, users:USERS, departments:DEPS, locations:LOC, logs:LOGS};
const COLORS = {'Actif':'success','En attente':'warning','Archivé':'primary','Expiré':'danger','Inactif':'secondary'};
const HEX = {'Actif':'#16a34a','En attente':'#f59e0b','Archivé':'#2563eb','Expiré':'#dc2626'};
const badge = s => `<span class="badge rounded-pill bg-${COLORS[s]||'secondary'}-subtle text-${COLORS[s]||'secondary'}-emphasis">${esc(s)}</span>`;
const locLabel = l => `${l.building} › ${l.floor} › ${l.room} › ${l.cabinet} › ${l.shelf} › ${l.box}`;

/* ---------- Notifications et confirmation ---------- */
const toast = (msg, type = 'success') => {
  const box = $('#toasts'); if (!box) return;
  const el = document.createElement('div');
  el.className = `toast align-items-center text-bg-${type} border-0`;
  el.setAttribute('role', type === 'danger' ? 'alert' : 'status');
  el.innerHTML = `<div class="d-flex"><div class="toast-body">${esc(msg)}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button></div>`;
  box.append(el); el.addEventListener('hidden.bs.toast', () => el.remove());
  new bootstrap.Toast(el, {delay:3500}).show();
};
let onOk = null;
const cmEl = $('#confirmModal'), cm = cmEl && new bootstrap.Modal(cmEl);
const confirmBox = (msg, cb, label = 'Confirmer') => { $('#confirmText').textContent = msg; $('#confirmOk').textContent = label; onOk = cb; cm.show(); };
$('#confirmOk')?.addEventListener('click', () => { cm.hide(); onOk && onOk(); });

/* ---------- Barre latérale ---------- */
const KEY = 'ams.sidebar', toggle = $('#sidebarToggle'), tips = [];
const setDrawer = open => { body.classList.toggle('sb-open', open); toggle?.setAttribute('aria-expanded', open); };
const syncTips = () => tips.forEach(t => (body.classList.contains('sb-collapsed') && !mq.matches) ? t.enable() : t.disable());
if (toggle) {
  try { if (!mq.matches && localStorage.getItem(KEY) === '1') body.classList.add('sb-collapsed'); } catch {}
  $$('.sb-link').forEach(a => {const label = a.dataset.label  || a.textContent.trim();if (!label)return;tips.push(new bootstrap.Tooltip(a, {title: label, placement:'right', trigger:'hover focus'}))});
  syncTips();
  toggle.setAttribute('aria-expanded', mq.matches ? 'false' : String(!body.classList.contains('sb-collapsed')));
  toggle.addEventListener('click', () => {
    if (mq.matches) return setDrawer(!body.classList.contains('sb-open'));
    const c = body.classList.toggle('sb-collapsed');
    toggle.setAttribute('aria-expanded', String(!c));
    try { localStorage.setItem(KEY, c ? '1' : '0'); } catch {}
    syncTips();
  });
  $('#sbOverlay').addEventListener('click', () => setDrawer(false));
  $$('.sb-link').forEach(a => a.addEventListener('click', () => setDrawer(false)));
  document.addEventListener('keydown', e => { if (e.key === 'Escape') setDrawer(false); });
  mq.addEventListener('change', () => { setDrawer(false); syncTips(); });
}

/* ---------- Validation (messages en français) ---------- */
const msgFor = el => {
  const v = el.validity;
  if (v.valueMissing) return 'Ce champ est obligatoire.';
  if (v.typeMismatch) return el.type === 'email' ? 'Saisissez une adresse e-mail valide.' : 'Valeur invalide.';
  if (v.tooShort) return `Saisissez au moins ${el.minLength} caractères.`;
  if (v.customError) return el.validationMessage;
  return 'Valeur invalide.';
};
const validate = form => {
  const exp = form.elements.expiry, dep = form.elements.date;
  if (exp && dep) exp.setCustomValidity(exp.value && dep.value && exp.value < dep.value ? "La date d'expiration doit suivre la date de dépôt." : '');
  let ok = true;
  $$('input,select,textarea', form).forEach(el => {
    if (!el.willValidate) return;
    const fb = (el.closest('.input-group') || el).parentElement.querySelector('.invalid-feedback');
    if (!el.checkValidity()) { ok = false; if (fb) fb.textContent = msgFor(el); }
  });
  return ok;
};
$$('form[data-validate]').forEach(form => form.addEventListener('submit', e => {
  e.preventDefault(); form.classList.add('was-validated');
  if (!validate(form)) { $(':invalid', form)?.focus(); toast('Veuillez corriger les champs signalés.', 'danger'); return; }
  form.dispatchEvent(new CustomEvent('valid'));
  if (form.dataset.success) { toast(form.dataset.success); if (form.dataset.redirect) setTimeout(() => location.href = form.dataset.redirect, 1200); }
}));

/* ---------- Tableaux : recherche, filtres, pagination, actions ---------- */
let current = null;
const initTable = t => {
  const src = DB[t.dataset.source], per = +t.dataset.per || 8, wrap = t.closest('[data-table-wrap]');
  const cols = $$('th[data-col]', t).map(th => th.dataset.col), acts = (t.dataset.actions || '').split(',').filter(Boolean), eh = t.dataset.editHref;
  const q = $('[data-search]', wrap), filters = $$('[data-filter]', wrap), df = $('[data-date-from]', wrap), pg = $('[data-pager]', wrap), empty = $('[data-empty]', wrap), count = $('[data-count]', wrap), tb = $('tbody', t);
  let page = 1;
  const param = new URLSearchParams(location.search).get('q'); if (q && param) q.value = param;
  const scope = () => src.filter(r => t.dataset.deleted === undefined || !!r.deleted === (t.dataset.deleted === 'true'));
  const filtered = () => {
    const s = (q?.value || '').toLowerCase().trim();
    let rows = scope().filter(r => (!s || Object.values(r).join(' ').toLowerCase().includes(s)) && filters.every(f => !f.value || String(r[f.dataset.filter]) === f.value) && (!df || !df.value || r.date >= df.value));
    if (t.dataset.sort === 'date-desc') rows = [...rows].sort((a, b) => b.date.localeCompare(a.date));
    return rows;
  };
  const btn = (act, icon, label, r, cls = 'outline-secondary') => `<button class="btn btn-sm btn-${cls}" data-act="${act}" data-id="${r.id}" title="${label}" aria-label="${label}"><i class="bi ${icon}"></i></button>`;
  const actionCell = r => `<div class="d-inline-flex gap-1">${acts.map(a => ({
    view: `<a class="btn btn-sm btn-outline-secondary" href="${t.dataset.viewHref}?id=${r.id}" title="Voir" aria-label="Voir ${esc(r.number)}"><i class="bi bi-eye"></i></a>`,
    edit: eh ? `<a class="btn btn-sm btn-outline-secondary" href="${eh}?id=${r.id}" title="Modifier" aria-label="Modifier ${esc(r.number)}"><i class="bi bi-pencil"></i></a>` : btn('edit','bi-pencil','Modifier',r),
    trash: btn('trash','bi-trash3','Mettre à la corbeille',r,'outline-danger'),
    restore: btn('restore','bi-arrow-counterclockwise','Restaurer',r,'outline-primary'),
    toggle: btn('toggle', r.status === 'Actif' ? 'bi-toggle-on' : 'bi-toggle-off', r.status === 'Actif' ? 'Désactiver' : 'Activer', r)
  }[a])).join('')}</div>`;
  const cell = (c, r) => c === 'actions' ? `<td class="text-end">${actionCell(r)}</td>` : `<td>${c === 'status' ? badge(r.status) : esc(fmt(r[c]))}</td>`;
  const render = () => {
    const rows = filtered(), pages = Math.max(1, Math.ceil(rows.length / per)); page = Math.min(page, pages);
    tb.innerHTML = rows.slice((page - 1) * per, page * per).map(r => `<tr>${cols.map(c => cell(c, r)).join('')}</tr>`).join('');
    empty?.classList.toggle('d-none', rows.length > 0); t.closest('.table-responsive').classList.toggle('d-none', !rows.length);
    if (count) count.textContent = `${rows.length} résultat${rows.length > 1 ? 's' : ''}`;
    if (pg) pg.innerHTML = pages < 2 ? '' : `<li class="page-item ${page===1?'disabled':''}"><button class="page-link" data-p="${page-1}">Précédent</button></li>` + Array.from({length:pages}, (_, i) => `<li class="page-item ${i+1===page?'active':''}"><button class="page-link" data-p="${i+1}" ${i+1===page?'aria-current="page"':''}>${i+1}</button></li>`).join('') + `<li class="page-item ${page===pages?'disabled':''}"><button class="page-link" data-p="${page+1}">Suivant</button></li>`;
  };
  const reset = () => { page = 1; render(); };
  q?.addEventListener('input', reset); filters.forEach(f => f.addEventListener('change', reset)); df?.addEventListener('change', reset);
  pg?.addEventListener('click', e => { const b = e.target.closest('[data-p]'); if (b) { page = +b.dataset.p; render(); } });
  tb.addEventListener('click', e => {
    const b = e.target.closest('[data-act]'); if (!b) return;
    const r = src.find(x => x.id === +b.dataset.id), label = r.number || r.name || r.code || r.box;
    if (b.dataset.act === 'trash') confirmBox(`Mettre « ${label} » à la corbeille ? Vous pourrez le restaurer.`, () => { r.deleted = true; r.deletedAt = new Date().toISOString().slice(0, 10); render(); toast('Archive déplacée vers la corbeille.'); }, 'Mettre à la corbeille');
    if (b.dataset.act === 'restore') confirmBox(`Restaurer « ${label} » dans le registre ?`, () => { r.deleted = false; render(); toast('Archive restaurée.'); }, 'Restaurer');
    if (b.dataset.act === 'toggle') { const on = r.status === 'Actif'; confirmBox(`${on ? 'Désactiver' : 'Activer'} « ${label} » ?`, () => { r.status = on ? 'Inactif' : 'Actif'; render(); toast(on ? 'Élément désactivé.' : 'Élément activé.'); }); }
    if (b.dataset.act === 'edit') openForm(r);
  });
  current = {src, filtered, cols, render};
  render();
};
$$('table[data-source]').forEach(initTable);

/* Export CSV de la sélection courante */
$('[data-export]')?.addEventListener('click', () => {
  const c = current.cols.filter(x => x !== 'actions'), rows = current.filtered();
  const csv = [c.join(';'), ...rows.map(r => c.map(k => `"${String(r[k] ?? '').replace(/"/g, '""')}"`).join(';'))].join('\n');
  const a = Object.assign(document.createElement('a'), {href:URL.createObjectURL(new Blob(['\ufeff' + csv], {type:'text/csv'})), download:'export.csv'});
  a.click(); URL.revokeObjectURL(a.href); toast('Export CSV généré.');
});

/* Fenêtre de création / modification */
const fm = $('[data-form-modal]'), fmI = fm && new bootstrap.Modal(fm), fmForm = fm && $('form', fm);
function openForm(r) {
  fmForm.reset(); fmForm.classList.remove('was-validated');
  $$('input,select,textarea', fmForm).forEach(el => { if (r && el.name in r) el.value = r[el.name]; });
  fmForm.elements.id.value = r ? r.id : '';
  $('.modal-title', fm).textContent = r ? 'Modifier' : $('[data-new]').dataset.titleNew;
  fmI.show();
}
$('[data-new]')?.addEventListener('click', () => openForm(null));
fmForm?.addEventListener('valid', () => {
  const data = Object.fromEntries(new FormData(fmForm)), id = +data.id; delete data.id;
  if (id) Object.assign(current.src.find(x => x.id === id), data);
  else current.src.push({id:Math.max(...current.src.map(x => x.id)) + 1, ...(current.src === DEPS ? {users:0} : {}), ...data});
  fmI.hide(); current.render(); toast(id ? 'Modifications enregistrées (démonstration).' : 'Élément créé (démonstration).');
});

/* ---------- Divers ---------- */
$$('[data-toggle-password]').forEach(b => b.addEventListener('click', () => {
  const i = $(b.dataset.togglePassword), show = i.type === 'password'; i.type = show ? 'text' : 'password';
  b.setAttribute('aria-label', show ? 'Masquer le mot de passe' : 'Afficher le mot de passe'); b.firstElementChild.className = `bi bi-eye${show ? '-slash' : ''}`;
}));
document.addEventListener('click', e => { const d = e.target.closest('[data-demo]'); if (d) { e.preventDefault(); toast(d.dataset.demo || 'Fonction disponible avec le backend.', 'info'); } });
$('[data-global-search]')?.addEventListener('submit', e => { e.preventDefault(); location.href = e.target.dataset.action + '?q=' + encodeURIComponent($('input', e.target).value); });
$$('input[type=file][data-preview]').forEach(inp => inp.addEventListener('change', () => {
  const box = $(inp.dataset.preview); box.innerHTML = '';
  [...inp.files].forEach(f => {
    const li = document.createElement('li'); li.className = 'file-item';
    const ic = f.type.startsWith('image/') ? `<img src="${URL.createObjectURL(f)}" alt="">` : '<i class="bi bi-file-earmark-text fs-3 text-primary"></i>';
    li.innerHTML = `${ic}<div class="min-w-0"><div class="text-truncate fw-medium">${esc(f.name)}</div><small class="text-muted">${(f.size/1048576).toFixed(2)} Mo</small></div>`; box.append(li);
  });
}));
const locDl = (l, cls = 'col-6') => [['Bâtiment',l.building],['Étage',l.floor],['Salle',l.room],['Armoire',l.cabinet],['Étagère',l.shelf],['Boîte',l.box]].map(([k, v]) => `<div class="${cls}"><dt class="text-muted small fw-normal">${k}</dt><dd class="mb-0">${esc(v)}</dd></div>`).join('');
const ls = $('[data-location-select]');
if (ls) {
  ls.innerHTML = '<option value="">Sélectionner un emplacement…</option>' + LOC.filter(l => l.status === 'Actif').map(l => `<option value="${l.id}">${esc(locLabel(l))}</option>`).join('');
  ls.addEventListener('change', () => { const l = LOC.find(x => x.id === +ls.value), box = $('#locDetail'); box.classList.toggle('d-none', !l); if (l) box.innerHTML = locDl(l, 'col-6 col-md-4'); });
}
if ($('[data-archive-page]')) {
  const a = ARCH.find(x => x.id === +new URLSearchParams(location.search).get('id')) || ARCH[0], l = LOC.find(x => x.id === a.location);
  $$('[data-field]').forEach(el => { el.innerHTML = el.dataset.field === 'status' ? badge(a.status) : esc(fmt(a[el.dataset.field])); });
  const st = $('#locDetailStatic'); if (st) st.innerHTML = locDl(l);
  const form = $('form[data-validate]'); if (form) { $$('[name]', form).forEach(el => { if (el.name in a) el.value = a[el.name]; }); ls.dispatchEvent(new Event('change')); }
  const e = $('[data-edit-link]'); if (e) e.href = `${e.getAttribute('href').split('?')[0]}?id=${a.id}`;
  $('[data-trash-one]')?.addEventListener('click', () => confirmBox(`Mettre « ${a.number} » à la corbeille ?`, () => { a.deleted = true; toast('Archive déplacée vers la corbeille.'); setTimeout(() => location.href = $('[data-trash-one]').dataset.redirect, 900); }, 'Mettre à la corbeille'));
}

/* ---------- Tableau de bord ---------- */
const live = ARCH.filter(a => !a.deleted);
const stats = {archives:live.length, users:USERS.filter(u => u.status === 'Actif').length, locations:LOC.length, pending:live.filter(a => a.status === 'En attente').length};
$$('[data-stat]').forEach(el => el.textContent = stats[el.dataset.stat]);
const ch = $('[data-chart="activity"]');
if (ch) {
  const m = ['Mai','Juin','Juil.','Août','Sept.','Oct.'], v = [42,58,51,73,66,81];
  ch.innerHTML = `<svg viewBox="0 0 600 235" class="w-100" role="img" aria-label="Archives ajoutées par mois : ${m.map((x, i) => x + ' ' + v[i]).join(', ')}">${[0,25,50,75,100].map(g => `<line x1="40" x2="590" y1="${200-g*1.8}" y2="${200-g*1.8}" stroke="#e5e9f0"/><text x="32" y="${204-g*1.8}" text-anchor="end" font-size="11" fill="#64748b">${g}</text>`).join('')}${v.map((n, i) => `<rect x="${65+i*90}" y="${200-n*1.8}" width="50" height="${n*1.8}" rx="4" fill="#2563eb"/><text x="${90+i*90}" y="${192-n*1.8}" text-anchor="middle" font-size="12" fill="#1f2937">${n}</text><text x="${90+i*90}" y="222" text-anchor="middle" font-size="12" fill="#475569">${m[i]}</text>`).join('')}</svg>`;
}
const dn = $('[data-chart="status"]');
if (dn) {
  let acc = 0; const parts = S.map(s => { const n = live.filter(a => a.status === s).length, from = acc / live.length * 100; acc += n; return {s, n, from, to:acc / live.length * 100}; });
  dn.innerHTML = `<div class="donut" role="img" aria-label="Répartition des archives par statut" style="background:conic-gradient(${parts.map(p => `${HEX[p.s]} ${p.from}% ${p.to}%`).join(',')})"></div><ul class="legend">${parts.map(p => `<li><span><i style="background:${HEX[p.s]}"></i>${p.s}</span><strong>${p.n}</strong></li>`).join('')}</ul>`;
}
})();