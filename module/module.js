function clock() {
	let clock = document.getElementById('clock');
	let timer = new Date();
	clock.innerHTML = timer.toLocaleTimeString();
}

setInterval(() => clock(), 1000);