const containers = document.querySelectorAll('.links');
const links = new Map([
    ['Ons verhaal', '/about'],
    ['dinges', '/test'],
    ['foo', '/bar']
])
containers.forEach((container) => {
    links.entries().forEach(([key, value]) => {
        const link = document.createElement('a');
        link.href = value;
        link.textContent = key;
        link.classList.add('cta-link');
        container.appendChild(link);
        console.log({link, container});
    });
});

