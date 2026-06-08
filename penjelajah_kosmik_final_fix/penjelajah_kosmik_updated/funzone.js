function generateStars() {

  const container = document.getElementById('starsContainer');
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

const cosmicFacts = [
    "Bulan Jupiter, Ganymede, lebih besar daripada planet Merkurius dan merupakan bulan terbesar di Tata Surya kita.",
    "Satu hari di Venus lebih lama daripada satu tahunnya. Venus butuh 243 hari Bumi untuk berotasi, tapi hanya 225 hari Bumi untuk mengelilingi Matahari.",
    "Di luar angkasa sana, terdapat awan alkohol raksasa bernama Sagittarius B2 yang mengandung miliaran liter alkohol melayang di dekat pusat galaksi Bimasakti.",
    "Luar angkasa benar-benar sunyi hampa udara. Tanpa atmosfer, gelombang suara tidak punya media untuk merambat, jadi ledakan bintang sekalipun tidak akan terdengar.",
    "Bintang neutron sangat padat. Satu sendok teh materi dari bintang neutron akan memiliki berat sekitar 6 miliar ton jika ditimbang di Bumi!",
    "Baju luar angkasa NASA berharga sangat mahal, satu set lengkapnya bisa mencapai sekitar 12 juta dolar AS atau sekitar 180 miliar rupiah.",
    "Matahari kita berukuran sangat raksasa, kamu bisa memasukkan sekitar 1,3 juta planet Bumi ke dalam rongga Matahari jika ia dikosongkan.",
    "Di planet Uranus dan Neptunus, para ilmuwan memperkirakan terjadi hujan berlian di dalam atmosfernya akibat tekanan ekstrem yang memadatkan karbon.",
    "Jejak kaki para astronaut Apollo di Bulan tidak akan hilang selama jutaan tahun karena Bulan tidak memiliki atmosfer, angin, ataupun air untuk menyapunya.",
    "Planet Mars memiliki ngarai raksasa bernama Valles Marineris yang panjangnya mencapai 4.000 km, jauh lebih besar dan dalam daripada Grand Canyon di Bumi.",
    "Galaksi tetangga kita, Andromeda, sedang bergerak mendekati Bimasakti dan diprediksi akan bertabrakan dalam waktu sekitar 4,5 miliar tahun lagi.",
    "Ada sebuah planet bernama 55 Cancri e yang massanya dua kali lipat Bumi, di mana sepertiga bagian dari planet ini kemungkinan besar terbentuk dari berlian murni.",
    "Luar angkasa tidak dimulai dari jarak yang sangat jauh; batas atmosfer Bumi dan luar angkasa (Garis Kármán) secara resmi hanya berjarak 100 km di atas kita.",
    "Meskipun Merkurius paling dekat dengan Matahari, Venus adalah planet terpanas karena atmosfer tebalnya memerangkap panas dalam efek rumah kaca ekstrem.",
    "Kecepatan angin badai di planet Neptunus bisa mencapai 2.100 km/jam, tiga kali lipat lebih cepat daripada kekuatan badai paling dahsyat yang pernah ada di Bumi."
];

let totalFactsCount = cosmicFacts.length;
let usedIndexes = []; 

function nextFact() {
    const factContentEl = document.getElementById("factContent");
    if (!factContentEl) return;

    factContentEl.style.opacity = 0;
    factContentEl.style.transform = "scale(0.98)";
    factContentEl.style.transition = "all 0.2s ease";

    setTimeout(() => {
        if (usedIndexes.length === totalFactsCount) {
            usedIndexes = [];
        }

        let randomIndex;
        do {
            randomIndex = Math.floor(Math.random() * totalFactsCount);
        } while (usedIndexes.includes(randomIndex));

        usedIndexes.push(randomIndex);
        const selectedFact = cosmicFacts[randomIndex];

        document.getElementById("factContent").innerText = selectedFact;
        document.getElementById("factNumber").innerText = randomIndex + 1;
        document.getElementById("currentFact").innerText = usedIndexes.length;

        factContentEl.style.opacity = 1;
        factContentEl.style.transform = "scale(1)";
    }, 200);
}
document.addEventListener("DOMContentLoaded", () => {
    generateStars();
    nextFact(); 
});