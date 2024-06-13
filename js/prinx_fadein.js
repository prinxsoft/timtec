window.addEventListener('scroll', slideInContent);

function slideInContent() {
  const slideInElements = document.querySelectorAll('.slide-in');

  slideInElements.forEach(element => {
    // Calculate the distance of the element from the top of the viewport
    const slideInAt = (window.scrollY + window.innerHeight) - (element.offsetHeight / 2);
    // Calculate the bottom of the element
    const elementBottom = element.offsetTop + element.offsetHeight;

    // Add 'active' class to trigger the animation
    if (slideInAt > element.offsetTop && window.scrollY < elementBottom) {
      element.classList.add('active');
    } else {
      element.classList.remove('active');
    }
  });
}
