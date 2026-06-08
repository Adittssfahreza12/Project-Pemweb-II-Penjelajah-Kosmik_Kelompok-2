function generateStars() {
  const container = document.getElementById('heroStars');
  if (!container) return;
  const count = 120;
  const fragment = document.createDocumentFragment();
  for (let i = 0; i < count; i++) {
    const star = document.createElement('div');
    const size = Math.random() * 2.5 + 0.5;
    star.style.cssText = `
      position: absolute;
      width: ${size}px;
      height: ${size}px;
      background: white;
      border-radius: 50%;
      top: ${Math.random() * 100}%;
      left: ${Math.random() * 100}%;
      opacity: ${Math.random() * 0.6 + 0.2};
      animation: twinkle ${Math.random() * 3 + 2}s ease-in-out infinite alternate;
      animation-delay: ${Math.random() * 3}s;
    `;
    fragment.appendChild(star);
  }
  container.appendChild(fragment);
}
const style = document.createElement('style');
style.textContent = `
  @keyframes twinkle {
    from { opacity: 0.2; transform: scale(1); }
    to   { opacity: 0.9; transform: scale(1.3); }
  }
`;
document.head.appendChild(style);
generateStars();


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

const planets = [
    {
        name: "Matahari", emoji: "☀️",
        gravity: 274, gravityRel: 27.97,
        color: "rgba(255,179,0,0.08)", accent: "#ffb300",
        type: "Bintang",
        fact: "Di Matahari, tekanan gravitasinya sangat besar sehingga tubuh manusia akan hancur seketika sebelum sampai ke permukaannya!",
        distance: "0 km (pusat tata surya)",
        temp: "5.500°C (permukaan)"
    },
    {
        name: "Merkurius", emoji: "⚫",
        gravity: 3.7, gravityRel: 0.38,
        color: "rgba(181,181,181,0.08)", accent: "#b5b5b5",
        type: "Planet Terestrial",
        fact: "Di Merkurius kamu hampir melayang! Gravitasinya begitu kecil sehingga kamu bisa melompat jauh lebih tinggi.",
        distance: "77,3 juta km dari Bumi",
        temp: "-173°C hingga 427°C"
    },
    {
        name: "Venus", emoji: "🟡",
        gravity: 8.87, gravityRel: 0.91,
        color: "rgba(213,143,29,0.08)", accent: "#d58f1d",
        type: "Planet Terestrial",
        fact: "Gravitasi Venus mirip dengan Bumi, namun suhu permukaannya mencapai 465°C dan tekanan atmosfernya 90x lipat Bumi!",
        distance: "261 juta km dari Bumi",
        temp: "465°C (rata-rata)"
    },
    {
        name: "Bumi", emoji: "🌍",
        gravity: 9.81, gravityRel: 1.00,
        color: "rgba(34,197,94,0.08)", accent: "#22c55e",
        type: "Planet Terestrial",
        fact: "Ini adalah berat badanmu di Bumi, planet rumah kita yang tercinta. Gravitasinya menjadi referensi untuk semua planet lain.",
        distance: "0 km (rumah kita!)",
        temp: "15°C (rata-rata)"
    },
    {
        name: "Bulan", emoji: "🌕",
        gravity: 1.62, gravityRel: 0.17,
        color: "rgba(200,200,200,0.08)", accent: "#c8c8c8",
        type: "Satelit Bumi",
        fact: "Di Bulan kamu bisa melompat setinggi 6x lipat! Para astronot Apollo berlompat-lompatan di permukaannya.",
        distance: "384.400 km dari Bumi",
        temp: "-173°C hingga 127°C"
    },
    {
        name: "Mars", emoji: "🔴",
        gravity: 3.72, gravityRel: 0.38,
        color: "rgba(255,112,67,0.08)", accent: "#ff7043",
        type: "Planet Terestrial",
        fact: "Gravitasi Mars hanya 38% Bumi. Koloni manusia di Mars kelak akan bisa melompat dan berlari lebih jauh dari di Bumi!",
        distance: "78,3 juta km dari Bumi",
        temp: "-63°C (rata-rata)"
    },
    {
        name: "Jupiter", emoji: "🟠",
        gravity: 24.79, gravityRel: 2.53,
        color: "rgba(209,163,107,0.08)", accent: "#d1a36b",
        type: "Planet Gas Raksasa",
        fact: "Di Jupiter kamu akan merasakan beban 2,5x lebih berat! Bergerak pun akan sangat sulit karena gravitasinya yang kuat.",
        distance: "628,7 juta km dari Bumi",
        temp: "-108°C (awan atas)"
    },
    {
        name: "Saturnus", emoji: "🪐",
        gravity: 10.44, gravityRel: 1.07,
        color: "rgba(215,196,128,0.08)", accent: "#d7c480",
        type: "Planet Gas Raksasa",
        fact: "Meski ukurannya raksasa, gravitasi Saturnus hampir sama dengan Bumi karena densitasnya sangat rendah (lebih ringan dari air!).",
        distance: "1,28 miliar km dari Bumi",
        temp: "-178°C (rata-rata)"
    },
    {
        name: "Uranus", emoji: "🔵",
        gravity: 8.69, gravityRel: 0.89,
        color: "rgba(126,226,245,0.08)", accent: "#7ee2f5",
        type: "Planet Es Raksasa",
        fact: "Uranus unik karena rotasinya hampir horizontal. Gravitasinya sedikit lebih kecil dari Venus, namun suhunya jauh lebih dingin.",
        distance: "2,72 miliar km dari Bumi",
        temp: "-224°C (rata-rata)"
    },
    {
        name: "Neptunus", emoji: "💙",
        gravity: 11.15, gravityRel: 1.14,
        color: "rgba(72,118,255,0.08)", accent: "#4876ff",
        type: "Planet Es Raksasa",
        fact: "Neptunus memiliki angin tercepat di tata surya hingga 2.100 km/jam. Gravitasinya sedikit lebih besar dari Bumi.",
        distance: "4,35 miliar km dari Bumi",
        temp: "-218°C (rata-rata)"
    }
];

let gender = 'pria';
let userWeight = 60;
let userHeight = 170;

function setGender(g, btn) {
    gender = g;
    document.querySelectorAll('.gender-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

function adjustValue(type, delta) {
    if (type === 'weight') {
        const inp = document.getElementById('weightInput');
        inp.value = Math.max(1, Math.min(300, parseInt(inp.value || 60) + delta));
    } else {
        const inp = document.getElementById('heightInput');
        inp.value = Math.max(50, Math.min(300, parseInt(inp.value || 170) + delta));
    }
}

function getBMICategory(bmi) {
    if (bmi < 18.5) return { cat: 'Kurus', color: '#64d9ff' };
    if (bmi < 25) return { cat: 'Normal', color: '#22c55e' };
    if (bmi < 30) return { cat: 'Gemuk', color: '#f59e0b' };
    return { cat: 'Obesitas', color: '#ef4444' };
}

function calculate() {
    userWeight = parseFloat(document.getElementById('weightInput').value) || 60;
    userHeight = parseFloat(document.getElementById('heightInput').value) || 170;

    if (userWeight <= 0 || userHeight <= 0) {
        alert('Masukkan berat dan tinggi yang valid!');
        return;
    }

    // BMI
    const heightM = userHeight / 100;
    const bmi = (userWeight / (heightM * heightM)).toFixed(1);
    const bmiCat = getBMICategory(parseFloat(bmi));
    const bmiDisplay = document.getElementById('bmiDisplay');
    bmiDisplay.classList.remove('hidden');
    document.getElementById('bmiValue').textContent = bmi;
    document.getElementById('bmiValue').style.color = bmiCat.color;
    document.getElementById('bmiCat').textContent = bmiCat.cat;

    // Render planet cards
    const panel = document.getElementById('resultsPanel');
    panel.innerHTML = `
        <h2 style="font-size:20px;color:#c084fc;margin-bottom:20px;text-align:center">
            🌍 Berat ${userWeight} kg di ${planets.length} Benda Langit
        </h2>
        <div class="planets-grid" id="planetsGrid"></div>
    `;

    const grid = document.getElementById('planetsGrid');
    planets.forEach((p, i) => {
        const weightOnPlanet = (userWeight * p.gravity / 9.81).toFixed(1);
        const isFav = isFavorite(p.name);
        const isEarth = p.name === 'Bumi';

        const card = document.createElement('div');
        card.className = `planet-result-card ${isEarth ? 'earth-card' : ''}`;
        card.style.setProperty('--planet-color', p.color);
        card.style.setProperty('--planet-accent', p.accent);
        card.innerHTML = `
            <span class="fav-star ${isFav ? 'active' : ''}" onclick="toggleFavFromCalc(event, '${p.name}', '${p.emoji}', '${p.type}', ${weightOnPlanet}, ${userWeight})" title="Simpan ke favorit">
                ${isFav ? '⭐' : '☆'}
            </span>
            <div class="planet-emoji">${p.emoji}</div>
            <div class="planet-name">${p.name}</div>
            <div class="planet-weight">${weightOnPlanet}</div>
            <div class="planet-weight-unit">kg</div>
            <div class="planet-gravity-badge">${p.gravityRel}g</div>
        `;
        card.onclick = () => openModal(p, weightOnPlanet);
        grid.appendChild(card);
    });
}

function openModal(p, weight) {
    document.getElementById('modalIcon').textContent = p.emoji;
    document.getElementById('modalName').textContent = p.name;
    document.getElementById('modalStats').innerHTML = `
        <div class="modal-stat">
            <div class="modal-stat-label">Berat di ${p.name}</div>
            <div class="modal-stat-value">${weight} kg</div>
        </div>
        <div class="modal-stat">
            <div class="modal-stat-label">Gravitasi</div>
            <div class="modal-stat-value">${p.gravity} m/s²</div>
        </div>
        <div class="modal-stat">
            <div class="modal-stat-label">Jenis</div>
            <div class="modal-stat-value" style="font-size:14px">${p.type}</div>
        </div>
        <div class="modal-stat">
            <div class="modal-stat-label">Suhu</div>
            <div class="modal-stat-value" style="font-size:14px">${p.temp}</div>
        </div>
    `;
    document.getElementById('modalFact').innerHTML = `💡 <strong>Fakta Menarik:</strong> ${p.fact}`;
    document.getElementById('modalOverlay').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modalOverlay').classList.add('hidden');
}

// Favorites integration
function isFavorite(planetName) {
    const favs = JSON.parse(localStorage.getItem('kosmikFavorit') || '[]');
    return favs.some(f => f.name === planetName);
}

function toggleFavFromCalc(e, name, emoji, type, weightOnPlanet, weightOnEarth) {
    e.stopPropagation();
    const favs = JSON.parse(localStorage.getItem('kosmikFavorit') || '[]');
    const idx = favs.findIndex(f => f.name === name);

    if (idx >= 0) {
        favs.splice(idx, 1);
        e.target.textContent = '☆';
        e.target.classList.remove('active');
    } else {
        favs.push({
            id: Date.now(),
            name, emoji, type,
            weightOnPlanet, weightOnEarth,
            addedAt: new Date().toLocaleDateString('id-ID'),
            category: 'planet'
        });
        e.target.textContent = '⭐';
        e.target.classList.add('active');
        showToast(`${name} ditambahkan ke Favorit!`);
    }
    localStorage.setItem('kosmikFavorit', JSON.stringify(favs));
}

function showToast(msg) {
    const t = document.createElement('div');
    t.style.cssText = `
    position:fixed;bottom:30px;right:30px;
    background:var(--color-accent);
    color:var(--color-bg);padding:14px 24px;border-radius:20px;
    font-family:var(--font-body);font-size:14px;font-weight:600;
    z-index:9999;animation:fadeInScale 0.3s ease;
    box-shadow:0 5px 25px rgba(91,174,232,0.4);
`;
    t.textContent = '⭐ ' + msg;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 2500);
}
