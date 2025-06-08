// cart------------------------------------
const cartBtn = document.getElementById('cartBtn');
const cartModal = document.getElementById('cartModal');
const closeBtn = cartModal.querySelector('.closeBtn');

// Show modal
cartBtn.addEventListener('click', () => {
  cartModal.classList.add('show');
});

// Hide modal
closeBtn.addEventListener('click', () => {
  cartModal.classList.remove('show');
});

// Hide modal when clicking outside the modal content
window.addEventListener('click', (e) => {
  if (e.target === cartModal) {
    cartModal.classList.remove('show');
  }
});

// -------------------------------------------------------------

const searchBtn = document.getElementById("searchBtn");
const watchlistBtn = document.getElementById("watchlistBtn");
const searchBar = document.getElementById("searchBar");
const watchlist = document.getElementById("watchlist");
const menuToggle = document.getElementById("menuToggle");
const navMenu = document.getElementById("navMenu");

searchBtn.addEventListener("click", () => {
  searchBar.classList.toggle("hidden");
  watchlist.classList.add("hidden");
});

watchlistBtn.addEventListener("click", () => {
  watchlist.classList.toggle("hidden");
  searchBar.classList.add("hidden");
});

menuToggle.addEventListener("click", () => {
  navMenu.classList.toggle("show");
});

// ----------------------------------------------profile dropdown

const profileBtn = document.getElementById("profileBtn");
const dropdown = document.getElementById("profileDropdown");

profileBtn.addEventListener("click", () => {
dropdown.style.display = dropdown.style.display === "flex" ? "none" : "flex";
});

document.addEventListener("click", (e) => {
if (!profileBtn.contains(e.target) && !dropdown.contains(e.target)) {
    dropdown.style.display = "none";
}
});

// -----------------------------------Silder--------------------------
const slides = document.querySelectorAll(".slider-container .slide"); // get all the slides
const eraser = document.querySelector(".eraser"); // the eraser
const prev = document.getElementById("previous"); // previous button
const next = document.getElementById("next"); // next button
const intervalTime = 6000; // time until nextSlide triggers in miliseconds
const eraserActiveTime = 500; // time to wait until the .eraser goes all the way
let sliderInterval; // variable used to save the setInterval and clear it when needed

const nextSlide = () => {
// Step 1. Add the .active class to the eraser - this will trigger the eraser to move to the left.
eraser.classList.add("active");
// Step 2. Set a timeout that will allow the eraser to move all the way to the left. This is where we'll use the eraserActiveTime - it has to be the same as the CSS value we mentioned above.
setTimeout(() => {
// Step 3. Get the active .slide and toggle the .active class on it (in this case, remove it).
const active = document.querySelector(".slide.active");
active.classList.toggle("active");
// Step 4. Check to see if the .slide has a next element sibling available. If it has, add the .active class to it.
if (active.nextElementSibling) {
    active.nextElementSibling.classList.toggle("active");
} else {
    // Step 5. If it's the last element in the list, add the .active class to the first slide (the one with index 0).
    slides[0].classList.toggle("active");
}
// Step 6.Remove the .active class from the eraser - this will trigger the eraser to move back to the right. It also waits 200 ms before doing this (just to give enough time for the next .slide to move in place).
setTimeout(() => {
    eraser.classList.remove("active");
}, 180);
}, eraserActiveTime);
};

//Button functionality
const prevSlide = () => {
eraser.classList.add("active");
setTimeout(() => {
const active = document.querySelector(".slide.active");
active.classList.toggle("active");
// The *changed* part from the nextSlide code
if (active.previousElementSibling) {
    active.previousElementSibling.classList.toggle("active");
} else {
    slides[slides.length - 1].classList.toggle("active");
}
// End of the changed part
setTimeout(() => {
    eraser.classList.remove("active");
}, 180);
}, eraserActiveTime);
};

next.addEventListener("click", () => {
nextSlide();
clearInterval(sliderInterval);
sliderInterval = setInterval(nextSlide, intervalTime);
});

prev.addEventListener("click", () => {
prevSlide();
clearInterval(sliderInterval);
sliderInterval = setInterval(nextSlide, intervalTime);
});

sliderInterval = setInterval(nextSlide, intervalTime);

// Initial slide
setTimeout(nextSlide, 500);

// -----------------------testimonials -------------------------

let current = 0;
const testimonials = document.querySelectorAll('.testimonial');

function showTestimonial(index) {
testimonials.forEach((t, i) => {
    t.classList.remove('active');
    if (i === index) t.classList.add('active');
});
}

function nextTestimonial() {
current = (current + 1) % testimonials.length;
showTestimonial(current);
}

function prevTestimonial() {
current = (current - 1 + testimonials.length) % testimonials.length;
showTestimonial(current);
}

setInterval(nextTestimonial, 6000);

//---------------bottom se top --------------------------


window.onscroll = function() {
  const btn = document.getElementById("scrollTopBtn");
  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
    btn.style.display = "block";
  } else {
    btn.style.display = "none";
  }
};

// Scroll to top smoothly
function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}


// -------------------------------------------------------------------
function changeImage(element) {
    const mainImage = document.getElementById('mainWatchImage');
    mainImage.src = element.src;
}

// ----------------------------------------------------------------------

const minRange = document.getElementById('minRange');
const maxRange = document.getElementById('maxRange');
const minInput = document.getElementById('minInput');
const maxInput = document.getElementById('maxInput');

function syncRangeToInput() {
    minInput.value = minRange.value;
    maxInput.value = maxRange.value;
}

function syncInputToRange() {
    minRange.value = minInput.value;
    maxRange.value = maxInput.value;
}

minRange.addEventListener('input', syncRangeToInput);
maxRange.addEventListener('input', syncRangeToInput);
minInput.addEventListener('change', syncInputToRange);
maxInput.addEventListener('change', syncInputToRange);

function toggleSection(id) {
    const section = document.getElementById(id);
    section.style.display = section.style.display === 'none' ? 'block' : 'none';
}

// ------------------------------------------------------------------------------

function switchLayout(columnCount) {
const grid = document.getElementById('productGrid');
grid.className = 'product-grid columns-' + columnCount;

document.querySelectorAll('.layout-button').forEach(btn => {
btn.classList.remove('active');
});
event.target.classList.add('active');
}


// -------------------------------------------
$(document).ready(function () {

  document.querySelectorAll(".particle").forEach(particle => {
    particle.style.animationDuration = `${10 + Math.random() * 20}s`;
  });
  
  var tabWrapper = $("#tab-block"),
  tabMnu = tabWrapper.find(".tab-mnu li"),
  tabContent = tabWrapper.find(".tab-cont > .tab-pane");

  // Hide all tab content except first
  tabContent.not(":first-child").hide();

  // Add data-tab attribute
  tabMnu.each(function (i) {
    $(this).attr("data-tab", "tab" + i);
  });
  tabContent.each(function (i) {
    $(this).attr("data-tab", "tab" + i);
  });

  // Tab click event
  tabMnu.click(function () {
    var tabData = $(this).data("tab");

    // Hide all and show selected tab content
    tabContent.hide();
    tabContent.filter("[data-tab=" + tabData + "]").show();

    // Change active class
    tabMnu.removeClass("active");
    $(this).addClass("active");
  });
});
// ------------------------------------------------

function openCustomTab(evt, tabName) {
  var i, tabpanel, tabbuttons;

  // Hide all tab panels
  tabpanel = document.getElementsByClassName("custom-tab-panel");
  for (i = 0; i < tabpanel.length; i++) {
    tabpanel[i].style.display = "none";
  }

  // Remove 'active-custom-tab' class from all tab buttons
  tabbuttons = document.getElementsByClassName("custom-tab-button");
  for (i = 0; i < tabbuttons.length; i++) {
    tabbuttons[i].classList.remove("active-custom-tab");
  }

  // Show the selected tab panel and add 'active-custom-tab' class to the clicked button
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.classList.add("active-custom-tab");
}

// Automatically click on the default tab when the page loads
document.getElementById("defaultCustomTab").click();

// ----------------------------------------------------------------------

function toggleBilling(show) {
  const billingForm = document.getElementById("billingForm");
  billingForm.style.display = show ? "block" : "none";
}

// Login script
function togglePassword() {
    const passInput = document.getElementById('password');
    const toggleBtn = event.target;
    if (passInput.type === 'password') {
      passInput.type = 'text';
      toggleBtn.textContent = 'HIDE';
    } else {
      passInput.type = 'password';
      toggleBtn.textContent = 'SHOW';
    }
  }
