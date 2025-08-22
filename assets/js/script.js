if (!loginOk ) {
  throw new Error("Incorrect login data, see config.php");
}

// Accessing DOM elements
const gE = (e)=> {
  const r = document.querySelectorAll(e);
  switch (r.length) {
    case 0: return null;
    case 1: return r[0];
    default: return r;
  }
}

const frm = gE("#frm");
const keys = gE('.key');
const keyCaptions = gE('.key-caption');
const rstation = gE(".rstation");
const pointer = gE("#img-pointer");
const mIcon = gE("#menu-icon");
const menuImg = gE("#menuImg");
const mItems = gE("#menu-items");
const keyboard = gE("#keyboard");
const expModal = gE("#exportModal");
const impModal = gE("#importModal");
const frmImport = gE("#frmImport");
const helpModal = gE("#helpModal");
const aboutModal = gE("#aboutModal");
const volume = gE("#volume");
const csvFn = gE("#csvFn");
const drop = gE("#drop");
const codec = gE("#codec");
const siriusImg = gE("#sirius-img");
const imgC = gE(".img-container");
const record = gE("#record");
const imgRec = gE("#img-record");
const search = gE("#search");
const vorschlag = gE("#vorschlag");
const stationIndex = gE("#stationIndex");
const uSi = gE("#useStationIndex");
let stationlist = null;
let sl = 0;
if (vorschlag) {
  let stationlist = vorschlag.children;
  sl = stationlist.length;
}


// Keyboard events
gE("#group").addEventListener("change", () =>{
  frm.submit();
})

for (let key of keys) {
  key.addEventListener("click", () =>{
    frm.submit();
  })
}


// Display scheme
function imgWidth() {
  return imgC.getBoundingClientRect().width;
}

let imgW = imgWidth();
switch (scheme) {
  case 0:
    if (key > 0) {
      const pPx = (42 + prevKey * 5) * imgW / 100;
      pointer.classList.remove('hidden');
      const cRs = gE("#rstation"+key);
      if (cRs) {
        cRs.classList.add("sel-c");
        setTimeout(()=>cRs.classList.add("sel-bg"),5000);
        pointer.style.left = pPx + "px";
      }
      rstation.forEach(s => {
        s.classList.remove('opacity0');
      })
      gE("#donau-maske").classList.add("opacity100");
    } else {
      pointer.classList.add('hidden');
      rstation.forEach(s => {
        s.classList.add('opacity0');
      })
    }
    break;
  case 1:
    if (key > 0){
      keyCaptions[key].style.backgroundImage = "url('assets/img/lighted.webp')";
    }
    break;
}

if (key > 0){
  imgC.classList.remove('grayscale');
  keyboard.classList.remove('grayscale');
} else {
  imgC.classList.add('grayscale');
  keyboard.classList.add('grayscale');
}


window.addEventListener("load", () => {
  let cPx;
  switch (scheme) {
    case 0:
      cPx = (42 + key * 5) * imgW / 100;
      pointer.style.left = cPx + "px";
      window.addEventListener("resize",()=>{
        imgW = imgWidth();
        cPx = (42 + key * 5) * imgW / 100;
        pointer.style.left = cPx + "px";
      });
      window.addEventListener("orientationchange",()=>{
        imgW = imgWidth();
        cPx = (42 + key * 5) * imgW / 100;
        pointer.style.left = cPx + "px";
      });
    break;
    case 1:
      keyCaptions[key].style.filter = 'brightness(100%)';
    break;
  }
});


// Menu
const mHeight = mItems.scrollHeight + "px";
mIcon.addEventListener("click", () =>{
  mItems.classList.toggle("opacity-90");
  if (mItems.classList.contains("opacity-90")){
    mItems.style.height = mHeight;
    menuImg.src = "assets/img/menu2"+scheme+".webp";
  } else {
    mItems.style.height = "0";
    menuImg.src = "assets/img/menu1"+scheme+".webp";
  }
  mItems.classList.toggle("hidden");
})

mIcon.addEventListener("mousedown",()=>{
  mIcon.classList.remove("shadow");
})

mIcon.addEventListener("touchstart",()=>{
  mIcon.classList.remove("shadow");
},{passive: true})

mIcon.addEventListener("mouseup",()=>{
  mIcon.classList.add("shadow");
})

mIcon.addEventListener("touchend",()=>{
  mIcon.classList.add("shadow");
})

// Export
gE("#btnExport").addEventListener("click", () =>{
  const file = new Blob([csvContent], {type:"text/csv"});
  const a = document.createElement("a");
  a.href = URL.createObjectURL(file);
  a.download = csvName;
  a.click();
  expModal.style.display = "none";
  mItems.classList.add("hidden");
})

gE("#btnMenuHelp").addEventListener("click", () =>{
  helpModal.style.display = "block";
  mItems.classList.add("hidden");
})


gE("#btnMenuExport").addEventListener("click", () =>{
  expModal.style.display = "block";
  mItems.classList.add("hidden");
})

gE("#btnAbout").addEventListener("click", ()=> {
  aboutModal.style.display = "block";
  mItems.classList.add("hidden");
})

gE(".closeD").forEach((e) => {
  e.addEventListener("click", ()=> {
    gE(".modal-dlg").forEach((m) => m.style.display = "none")
  })
})


// Import
gE("#btnMenuImport").addEventListener("click", () =>{
  impModal.style.display = "block";
  mItems.classList.add("hidden");
})

csvFn.addEventListener("change",()=>{
  if (csvFn.files[0].name != "") {
    gE("#btnImport").removeAttribute("disabled");
  }
})

function preventDefaults (e) {
	e.preventDefault();
	e.stopPropagation();
}

['dragenter','dragover','dragleave','drop'].forEach(evt => {
	drop.addEventListener(evt, preventDefaults, false);
});

['dragenter','dragover'].forEach(evt => {
	drop.addEventListener(evt,()=>{
    drop.classList.add('dragover');
  }, false);
});

['dragleave','drop'].forEach(evt => {
	drop.addEventListener(evt,()=>{
    drop.classList.remove('dragover');
  }, false);
});

drop.addEventListener('drop',(e)=> {
	csvFn.files  = e.dataTransfer.files;
  frmImport.submit();
});

btnImport.addEventListener("click",()=>{
  frmImport.submit();
})


// Scheme
gE("#scheme").addEventListener("change",()=>{
  frm.submit();
})

// Recording
if (record) {
  record.addEventListener("click",()=>{
    if (recordV == 1) {
      record.value = 0;
    } else {
      record.value = 1;
    }
    frm.submit();
  })
}

if (imgRec) {
  imgRec.addEventListener("mousedown",()=> {
    imgRec.classList.remove("shadow");
  })
  imgRec.addEventListener("mouseup",()=> {
    imgRec.classList.add("shadow");
  })
}

// Volume
function changeVol() {
    gE("#show-vol").innerText = volume.value;
    if (volVal != volume.value) {
      frm.submit();
    }
}

['change','mouseleave'].forEach(evt => {
	volume.addEventListener(evt, changeVol, false);
});

volume.addEventListener("wheel",(e)=>{
  let _v = volume.value;
  if (e.deltaY < 0 && _v < 100) {
      _v++;
  }
  if (e.deltaY > 0 && _v > 0) {
      _v--;
  }
  gE("#show-vol").innerText = _v;
  volume.value = _v;
},{passive: true})


// Codec infos
function showInfo(i) {
  if (i.result == 0) {
    let o = "";
    if (i.Name) {
      o += i.Name;
    }
    if (i.title) {
      o += "<br>" + i.title;
    }
    if (i.album) {
      o += "<br>" + i.album;
    }
    if (i.artist) {
      o += "<br>" + i.artist;
    }
    if (i.composer) {
      o += "<br>" + i.composer;
    }
    if (i.date) {
      o += "<br>" + i.date;
    }
    if (i.genre) {
      o += "<br>" + i.genre;
    }
    if (i.Genre) {
      o += "<br>" + i.Genre;
    }
    if (i.Info) {
      o += "<br>" + i.Info;
    }
    if (i.duration) {
      o += "<br>Duration: " + i.duration;
    }    if (i.Bitrate) {
      o += "<br>Bit rate: " + i.Bitrate;
    }
    if (i.sample_rate) {
      o += "<br>Sample rate: " + i.sample_rate;
    }
    if (i.channels) {
      o += "<br>Channels: " + i.channels;
    }
    if (i.Format) {
      o += "<br>" + i.Format;
    }
    if (i.URL) {
      o += "<br>" + i.URL;
    }
    if (i.raw) {
      o += "<br>" + i.raw;
    }
    codec.innerHTML = o;
  }
}

// Display codec info
setInterval(()=>{
  if (url != '') {
    if (url.slice(-4) != "m3u8" && url.slice(0,4) == 'http') {
      fetch(srv + "/codec.php?url=" + url)
      .then((response) => response.json())
      .then((json) => showInfo(json));
    }
  }
}, 10000);


// Sirius slideshow
setInterval(()=>{
  if (siriusImg) {
    let imgSrc = gE(".img-container img").src;
    imgC.animate([
      {opacity: '0'},
      {opacity: '1'}
    ], {duration: 500,
      direction: 'alternate',
      iteration: Infinity
    });
    const regex = /(.*)sirius(\d*).jpg/gm;
    let m;

    while ((m = regex.exec(imgSrc)) !== null) {
        if (m.index === regex.lastIndex) {
            regex.lastIndex++;
        }
        let i = parseInt(m[2]) + 1;
        if (i > 20) {
          i = 1;
        }
        imgSrc = m[1] + "sirius" + i + ".jpg";
        gE(".img-container img").src = imgSrc;
    }
  }
}, 8000);


// Direkt input
if (stationlist) {
  const stations = [];
  for (let i=0; i < sl; i++) {
    stations.push(stationlist[i].innerText);
  }

  search.addEventListener('input', (e)=> {
    const v = search.value.toLowerCase();
    if (v) {
      for (let i=0; i < sl; i++) {
        if (stations[i].toLowerCase().includes(v)) {
          stationlist[i].classList.add("show");
          stationlist[i].addEventListener("click", ()=>{
            search.value = stations[i];
            stationIndex.value = i;
            uSi.value = 1;
            frm.submit();
          })
        } else {
          uSi.value = 0;
          stationlist[i].classList.remove("show");
        }
      }
    } else {
      for (let i=0; i < sl; i++) {
        stationlist[i].classList.remove("show");
      }
      stationIndex.value = "";
      uSi.value = 0;
    }
  })
}

// Click on background
window.addEventListener("click", function(e){
  if (stationlist && search != e.target) {
    search.value = "";
    for (let i=0; i < sl; i++) {
      stationlist[i].classList.remove("show");
    }
    stationIndex.value = "";
    uSi.value = 0;
  }
  if ([expModal, impModal, helpModal, search, mIcon].includes(e.target)){
    expModal.style.display = "none";
    impModal.style.display = "none";
    helpModal.style.display = "none";
  }
  if (menuImg != e.target) {
    mItems.classList.add("hidden");
    menuImg.src = "assets/img/menu1"+scheme+".webp";
    mItems.classList.remove("opacity-90");
  }
})
