document.addEventListener('DOMContentLoaded', function() {
    // Handle dropdown menu clicks
    const dropdowns = document.querySelectorAll('.nav-item-dropdown > a');
    
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Close all other dropdowns
            dropdowns.forEach(other => {
                if (other !== dropdown) {
                    other.parentElement.querySelector('.dropdown-menu').style.display = 'none';
                    other.querySelector('.bi-chevron-right').style.transform = 'rotate(0deg)';
                }
            });
            
            // Toggle current dropdown
            const menu = this.nextElementSibling;
            const chevron = this.querySelector('.bi-chevron-right');
            
            if (menu.style.display === 'block') {
                menu.style.display = 'none';
                chevron.style.transform = 'rotate(0deg)';
            } else {
                menu.style.display = 'block';
                chevron.style.transform = 'rotate(90deg)';
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-item-dropdown')) {
            dropdowns.forEach(dropdown => {
                dropdown.parentElement.querySelector('.dropdown-menu').style.display = 'none';
                dropdown.querySelector('.bi-chevron-right').style.transform = 'rotate(0deg)';
            });
        }
    });
}); 