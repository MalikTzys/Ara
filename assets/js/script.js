// Custom JavaScript untuk Sistem Informasi Alumni
// Import Bootstrap
const bootstrap = window.bootstrap

document.addEventListener("DOMContentLoaded", () => {
  // Initialize tooltips
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl))

  // Initialize popovers
  var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
  var popoverList = popoverTriggerList.map((popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl))

  // Auto-hide alerts after 5 seconds
  setTimeout(() => {
    var alerts = document.querySelectorAll(".alert")
    alerts.forEach((alert) => {
      if (alert.classList.contains("alert-success") || alert.classList.contains("alert-info")) {
        var bsAlert = new bootstrap.Alert(alert)
        bsAlert.close()
      }
    })
  }, 5000)

  // Smooth scrolling for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault()
      const target = document.querySelector(this.getAttribute("href"))
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        })
      }
    })
  })

  // Form validation
  var forms = document.querySelectorAll(".needs-validation")
  Array.prototype.slice.call(forms).forEach((form) => {
    form.addEventListener(
      "submit",
      (event) => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add("was-validated")
      },
      false,
    )
  })

  // Search functionality
  const searchInput = document.querySelector('input[name="search"]')
  if (searchInput) {
    searchInput.addEventListener("input", () => {
      // Add search suggestions or live search functionality here
    })
  }

  // Image lazy loading
  const images = document.querySelectorAll("img[data-src]")
  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const img = entry.target
        img.src = img.dataset.src
        img.classList.remove("lazy")
        imageObserver.unobserve(img)
      }
    })
  })

  images.forEach((img) => imageObserver.observe(img))

  // Back to top button
  const backToTopButton = document.createElement("button")
  backToTopButton.innerHTML = '<i class="fas fa-chevron-up"></i>'
  backToTopButton.className = "btn btn-primary position-fixed"
  backToTopButton.style.cssText =
    "bottom: 20px; right: 20px; z-index: 1000; display: none; border-radius: 50%; width: 50px; height: 50px;"
  document.body.appendChild(backToTopButton)

  window.addEventListener("scroll", () => {
    if (window.pageYOffset > 300) {
      backToTopButton.style.display = "block"
    } else {
      backToTopButton.style.display = "none"
    }
  })

  backToTopButton.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    })
  })
})

// Utility functions
function showLoading(element) {
  element.innerHTML = '<span class="loading"></span> Loading...'
  element.disabled = true
}

function hideLoading(element, originalText) {
  element.innerHTML = originalText
  element.disabled = false
}

function showAlert(message, type = "info") {
  const alertDiv = document.createElement("div")
  alertDiv.className = `alert alert-${type} alert-dismissible fade show`
  alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `

  const container = document.querySelector(".container")
  if (container) {
    container.insertBefore(alertDiv, container.firstChild)
  }
}

// AJAX helper function
function makeRequest(url, method = "GET", data = null) {
  return fetch(url, {
    method: method,
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest",
    },
    body: data ? JSON.stringify(data) : null,
  })
    .then((response) => response.json())
    .catch((error) => {
      console.error("Error:", error)
      showAlert("Terjadi kesalahan. Silakan coba lagi.", "danger")
    })
}
