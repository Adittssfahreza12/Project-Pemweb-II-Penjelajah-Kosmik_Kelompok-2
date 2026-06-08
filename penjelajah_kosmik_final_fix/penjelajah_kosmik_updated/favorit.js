// Shooting stars
function createShootingStar() {
    const star = document.createElement("div");
    star.className = "shooting-star";
    star.style.left = Math.random() * 100 + "%";
    star.style.top = Math.random() * -200 + "px";
    star.style.animationDelay = Math.random() * 3 + "s";
    document.getElementById("starsContainer").appendChild(star);
    setTimeout(() => star.remove(), 6000);
}
setInterval(createShootingStar, 200);
for (let i = 0; i < 30; i++) setTimeout(createShootingStar, i * 100);

const KEY = 'kosmikFavorit';
let activeCategory = 'semua';
let searchQuery = '';

function getActiveUser() {
    try {
        const raw = sessionStorage.getItem('pk_user');
        return raw ? JSON.parse(raw) : null;
    } catch (e) {
        return null;
    }
}

async function postJSON(url, payload) {
    const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    });
    if (!res.ok) throw new Error('NETWORK_ERROR');
    return await res.json();
}


function getFavs() {
    return JSON.parse(localStorage.getItem(KEY) || '[]');
}
function saveFavs(favs) {
    localStorage.setItem(KEY, JSON.stringify(favs));
}

function updateStats() {
    const favs = getFavs();
    document.getElementById('totalFav').textContent = favs.length;
    document.getElementById('planetCount').textContent = favs.filter(f => f.category === 'planet').length;
    document.getElementById('factCount').textContent = favs.filter(f => f.category === 'fakta').length;
}

function renderFavs() {
    updateStats();
    let favs = getFavs();

    // Filter by category
    if (activeCategory !== 'semua') {
        favs = favs.filter(f => f.category === activeCategory);
    }

    // Filter by search
    if (searchQuery) {
        const q = searchQuery.toLowerCase();
        favs = favs.filter(f =>
            f.name.toLowerCase().includes(q) ||
            (f.body && f.body.toLowerCase().includes(q))
        );
    }

    const container = document.getElementById('favsContainer');
    const emptyState = document.getElementById('emptyState');

    if (favs.length === 0) {
        container.innerHTML = '';
        emptyState.classList.remove('hidden');
        return;
    }
    emptyState.classList.add('hidden');
    container.innerHTML = '';

    favs.forEach(fav => {
        const card = document.createElement('div');
        card.className = 'fav-card';
        card.dataset.id = fav.id;

        let bodyHTML = '';
        if (fav.category === 'planet') {
            bodyHTML = `
                <div class="fav-body planet-stats">
                    <div class="fav-stat">
                        <div class="fav-stat-val">${fav.weightOnPlanet} kg</div>
                        <div class="fav-stat-lbl">Beratmu di sana</div>
                    </div>
                    <div class="fav-stat">
                        <div class="fav-stat-val">${fav.weightOnEarth} kg</div>
                        <div class="fav-stat-lbl">Beratmu di Bumi</div>
                    </div>
                </div>
            `;
        } else {
            bodyHTML = `<div class="fav-body">${escapeHtml(fav.body || '')}</div>`;
        }

        card.innerHTML = `
            <div class="fav-card-top">
                <div class="fav-emoji">${fav.emoji}</div>
                <div class="fav-info">
                    <div class="fav-name">${escapeHtml(fav.name)}</div>
                    <div class="fav-type">${fav.type}</div>
                    <div class="fav-date">📅 ${fav.addedAt}</div>
                </div>
            </div>
            ${bodyHTML}
            <div class="fav-card-actions">
                <button class="share-btn" onclick="shareFav(${fav.id})">📤 Bagikan</button>
                <button class="remove-btn" onclick="removeFav(${fav.id})">🗑️ Hapus</button>
            </div>
        `;
        container.appendChild(card);
    });
}

function removeFav(id) {
    let favs = getFavs();
    const fav = favs.find(f => f.id === id);
    favs = favs.filter(f => f.id !== id);
    saveFavs(favs);
    renderFavs();
    showToast('Dihapus dari favorit');

    const user = getActiveUser();
    if (fav && user && user.id) {
        void postJSON('favorit_api.php', {
            action: 'remove_by_id',
            user_id: user.id,
            id: fav.id
        });
    }
}

function shareFav(id) {
    const fav = getFavs().find(f => f.id === id);
    if (!fav) return;
    let text = `🌌 Penjelajah Kosmik - ${fav.emoji} ${fav.name}\n`;
    if (fav.category === 'planet') {
        text += `Beratku di ${fav.name}: ${fav.weightOnPlanet} kg (di Bumi: ${fav.weightOnEarth} kg)`;
    } else {
        text += fav.body;
    }

    if (navigator.share) {
        navigator.share({ title: 'Penjelajah Kosmik', text });
    } else {
        navigator.clipboard.writeText(text).then(() => showToast('Disalin ke clipboard!'));
    }
}

function filterByCategory(cat, btn) {
    activeCategory = cat;
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    renderFavs();
}

function filterFavs() {
    searchQuery = document.getElementById('searchInput').value.trim();
    renderFavs();
}

function addManualFact() {
    const title = document.getElementById('factTitleInput').value.trim();
    const emoji = document.getElementById('factEmojiInput').value.trim() || '💡';
    const body = document.getElementById('factBodyInput').value.trim();

    if (!title) { showToast('Judul fakta tidak boleh kosong!'); return; }
    if (!body) { showToast('Isi fakta tidak boleh kosong!'); return; }

    const user = getActiveUser();

    if (user && user.id) {
        void postJSON('favorit_api.php', {
            action: 'add',
            user_id: user.id,
            kategori: 'fakta',
            nama: title,
            emoji: emoji,
            tipe: 'Fakta Kosmik',
            isi: body
        })
        .then(() => {
            syncFromDB();
            showToast('Fakta berhasil disimpan!');
        })
        .catch(() => showToast('Gagal menyimpan fakta ke database'));
    } else {
        const favs = getFavs();
        favs.unshift({
            id: Date.now(),
            name: title,
            emoji: emoji,
            type: 'Fakta Kosmik',
            body: body,
            category: 'fakta',
            addedAt: new Date().toLocaleDateString('id-ID')
        });
        saveFavs(favs);
        renderFavs();
        showToast('Fakta berhasil disimpan!');
    }

    document.getElementById('factTitleInput').value = '';
    document.getElementById('factEmojiInput').value = '';
    document.getElementById('factBodyInput').value = '';
}

function confirmClearAll() {
    document.getElementById('confirmModal').classList.remove('hidden');
}
function closeConfirm() {
    document.getElementById('confirmModal').classList.add('hidden');
}
function clearAll() {
    const user = getActiveUser();
    if (user && user.id) {
        void postJSON('favorit_api.php', {
            action: 'clear',
            user_id: user.id
        }).catch(() => {});
    }

    saveFavs([]);
    closeConfirm();
    renderFavs();
    showToast('Semua favorit dihapus');
}

function showToast(msg) {
    const existing = document.querySelector('.toast-notif');
    if (existing) existing.remove();

    const t = document.createElement('div');
    t.className = 'toast-notif';
    t.style.cssText = `
    position:fixed;bottom:30px;right:30px;
    background:linear-gradient(to right,#a855f7,#64d9ff);
    color:white;padding:14px 24px;border-radius:14px;
    font-size:15px;z-index:200;
    box-shadow:0 5px 25px rgba(168,85,247,0.4);
    animation:toastIn 0.3s ease;
`;
    t.textContent = msg;
    document.body.appendChild(t);
    const style = document.createElement('style');
    style.textContent = '@keyframes toastIn{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}';
    document.head.appendChild(style);
    setTimeout(() => t.remove(), 2500);
}

function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

// ── Sync DB → localStorage saat halaman favorit dibuka ──────
function mapFavRow(row) {
    return {
        id: parseInt(row.id, 10),
        name: row.nama,
        emoji: row.emoji || '⭐',
        type: row.tipe || (row.kategori === 'fakta' ? 'Fakta Kosmik' : 'Planet Tata Surya'),
        body: row.isi || '',
        category: row.kategori,
        weightOnPlanet: row.berat_di_planet !== null && row.berat_di_planet !== undefined ? parseFloat(row.berat_di_planet) : undefined,
        weightOnEarth: row.berat_di_bumi !== null && row.berat_di_bumi !== undefined ? parseFloat(row.berat_di_bumi) : undefined,
        addedAt: row.tanggal || '-'
    };
}

async function syncFromDB() {
    try {
        const user = getActiveUser();
        if (!user || !user.id) { renderFavs(); return; }

        const res = await postJSON('favorit_api.php', {
            action: 'list',
            user_id: user.id
        });

        if (!res.success) { renderFavs(); return; }

        const synced = Array.isArray(res.data) ? res.data.map(mapFavRow) : [];
        saveFavs(synced);
        renderFavs();
    } catch(e) {
        renderFavs();
    }
}

// Init
syncFromDB();
