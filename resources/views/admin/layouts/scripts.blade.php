<!-- jQuery FIRST -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>



<!-- DataTables - Latest Version -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>   

<!-- Page Specific JS -->
<script  type="text/javascript" src="https://cdn.jsdelivr.net/npm/apexcharts"></script>



<!-- Vendor js -->
<script src="https://coderthemes.com/greeva/layouts/assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="https://coderthemes.com/greeva/layouts/assets/js/app.js"></script>

<!-- Apex Chart js -->
<script src="https://coderthemes.com/greeva/layouts/assets/vendor/apexcharts/apexcharts.min.js"></script>

<!-- Vector Map Js -->
<script src="https://coderthemes.com/greeva/layouts/assets/vendor/jsvectormap/jsvectormap.min.js"></script>
<script src="https://coderthemes.com/greeva/layouts/assets/vendor/jsvectormap/maps/world-merc.js"></script>
<script src="https://coderthemes.com/greeva/layouts/assets/vendor/jsvectormap/maps/world.js"></script>

<!-- Iconify Icons -->
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios@1.6.0/dist/axios.min.js"></script>

<!-- Custom Scripts -->
<script>
    // Performance optimizations
    $(document).ready(function() {
        // Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Optimized DataTable initialization with better performance
        // Note: Individual pages should initialize their own DataTables
        // This prevents conflicts with custom configurations
      

        // Initialize Select2 with performance optimizations
        if (typeof $.fn.select2 !== 'undefined') {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'اختر خياراً',
                allowClear: true,
                minimumInputLength: 0,
                ajax: {
                    delay: 250, // Debounce search requests
                    cache: true // Cache results
                }
            });
        }

        // Initialize dropdowns
        var dropdowns = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        dropdowns.map(function (dropdownToggle) {
            new bootstrap.Dropdown(dropdownToggle)
        });

        // Sidebar toggle
        const sidebarHide = document.getElementById('sidebar-hide');
        if (sidebarHide) {
            sidebarHide.addEventListener('click', function(e) {
                e.preventDefault();
                document.body.classList.toggle('sidebar-collapse');
            });
        }

        // Enhanced Sidebar Dropdown Handling
        initializeSidebarDropdowns();

        // Safe initialization functions
        if (typeof layout_change !== 'undefined') {
            layout_change('light');
        }
        if (typeof layout_sidebar_change !== 'undefined') {
            layout_sidebar_change('light');
        }
        
        if (typeof layout_caption_change !== 'undefined') {
            layout_caption_change('true');
        }
        if (typeof layout_rtl_change !== 'undefined') {
            layout_rtl_change('false');
        }

        // Performance monitoring
        if (window.performance && window.performance.timing) {
            window.addEventListener('load', function() {
                setTimeout(function() {
                    const timing = window.performance.timing;
                    const loadTime = timing.loadEventEnd - timing.navigationStart;
                    console.log('Page load time:', loadTime + 'ms');
                }, 0);
            });
        }
    });

    // Enhanced Sidebar Dropdown Initialization
    function initializeSidebarDropdowns() {
        const sidebarDropdowns = document.querySelectorAll('.side-nav .dropdown-toggle');
        
        sidebarDropdowns.forEach(dropdown => {
            const dropdownMenu = dropdown.nextElementSibling;
            
            if (dropdownMenu && dropdownMenu.classList.contains('dropdown-menu')) {
                // Add hover functionality for desktop
                if (window.innerWidth > 768) {
                    dropdown.addEventListener('mouseenter', function() {
                        // Close other dropdowns
                        sidebarDropdowns.forEach(otherDropdown => {
                            if (otherDropdown !== dropdown) {
                                const otherMenu = otherDropdown.nextElementSibling;
                                if (otherMenu && otherMenu.classList.contains('dropdown-menu')) {
                                    otherMenu.classList.remove('show');
                                    otherDropdown.setAttribute('aria-expanded', 'false');
                                }
                            }
                        });
                        
                        // Show current dropdown
                        dropdownMenu.classList.add('show');
                        dropdown.setAttribute('aria-expanded', 'true');
                    });
                    
                    // Hide dropdown when mouse leaves
                    const dropdownContainer = dropdown.parentElement;
                    dropdownContainer.addEventListener('mouseleave', function() {
                        dropdownMenu.classList.remove('show');
                        dropdown.setAttribute('aria-expanded', 'false');
                    });
                }
                
                // Click functionality for mobile
                dropdown.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        e.preventDefault();
                        const isExpanded = dropdown.getAttribute('aria-expanded') === 'true';
                        
                        // Close other dropdowns
                        sidebarDropdowns.forEach(otherDropdown => {
                            if (otherDropdown !== dropdown) {
                                const otherMenu = otherDropdown.nextElementSibling;
                                if (otherMenu && otherMenu.classList.contains('dropdown-menu')) {
                                    otherMenu.classList.remove('show');
                                    otherDropdown.setAttribute('aria-expanded', 'false');
                                }
                            }
                        });
                        
                        // Toggle current dropdown
                        if (isExpanded) {
                            dropdownMenu.classList.remove('show');
                            dropdown.setAttribute('aria-expanded', 'false');
                        } else {
                            dropdownMenu.classList.add('show');
                            dropdown.setAttribute('aria-expanded', 'true');
                        }
                    }
                });
            }
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.side-nav-item')) {
                sidebarDropdowns.forEach(dropdown => {
                    const dropdownMenu = dropdown.nextElementSibling;
                    if (dropdownMenu && dropdownMenu.classList.contains('dropdown-menu')) {
                        dropdownMenu.classList.remove('show');
                        dropdown.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        });
    }

    // Global AJAX error handler
    $(document).ajaxError(function(event, xhr, settings, error) {
        console.error('AJAX Error:', error);
        if (xhr.status === 419) { // CSRF token mismatch
            Swal.fire({
                icon: 'error',
                title: 'انتهت صلاحية الجلسة',
                text: 'يرجى تحديث الصفحة والمحاولة مرة أخرى.',
                confirmButtonText: 'حسناً'
            });
        }
    });

    // Debounce function for performance
    function debounce(func, wait, immediate) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Handle window resize for responsive sidebar
    window.addEventListener('resize', debounce(function() {
        initializeSidebarDropdowns();
    }, 250));

    // Enhanced dropdown positioning for RTL
    function adjustDropdownPosition() {
        const dropdowns = document.querySelectorAll('.side-nav .dropdown-menu');
        dropdowns.forEach(dropdown => {
            const rect = dropdown.getBoundingClientRect();
            const viewportWidth = window.innerWidth;
            
            // Check if dropdown goes outside viewport
            if (rect.right > viewportWidth) {
                dropdown.style.left = 'auto';
                dropdown.style.right = '100%';
            }
        });
    }

    // Call position adjustment after dropdowns are shown
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    if (mutation.target.classList.contains('show')) {
                        adjustDropdownPosition();
                    }
                }
            });
        });
        
        const dropdowns = document.querySelectorAll('.side-nav .dropdown-menu');
        dropdowns.forEach(dropdown => {
            observer.observe(dropdown, { attributes: true });
        });
    });
</script>

<!-- Custom Scripts -->
<script src="{{ asset('assets/js/datatables-optimized.js') }}"></script>
<script src="{{ asset('assets/js/sidebar-enhanced.js') }}"></script>

@stack('scripts') 