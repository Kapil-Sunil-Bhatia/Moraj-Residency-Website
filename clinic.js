const prev = document.getElementById('activity-prev-btn')
const next = document.getElementById('activity-next-btn')
const list = document.getElementById('activity-item-list')

const itemWidth = 1000
const padding = 10

prev.addEventListener('click',()=>{
  list.scrollLeft -= itemWidth + padding
})

next.addEventListener('click',()=>{
  list.scrollLeft += itemWidth + padding
})

// Automatic carousel slide
let currentIndex = 0;
const slideInterval = 1500; // Change slide every 3 seconds

function nextSlide() {
  currentIndex = (currentIndex + 1) % list.children.length;
  list.scrollTo({
    left: currentIndex * (itemWidth + padding),
    behavior: 'smooth'
  });
}

// Start automatic slide
let slideTimer = setInterval(nextSlide, slideInterval);

// Pause automatic slide when mouse hovers over the carousel
list.addEventListener('mouseenter', () => {
  clearInterval(slideTimer);
});

// Resume automatic slide when mouse leaves the carousel
list.addEventListener('mouseleave', () => {
  slideTimer = setInterval(nextSlide, slideInterval);
});