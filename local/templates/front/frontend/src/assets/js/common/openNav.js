export default function openNav() {
	let bodyState = document.body.classList.contains('nav-open');
	bodyState
		? (document.body.classList.remove("nav-open"))
		: (document.body.classList.add("nav-open"));
}
