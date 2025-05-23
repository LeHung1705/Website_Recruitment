 // Xử lý upload file
        document.querySelector('.upload-area').addEventListener('click', function() {
            this.querySelector('input[type="file"]').click();
        });
        
        document.querySelector('.upload-area input').addEventListener('change', function(e) {
            if(e.target.files.length > 0) {
                const fileName = e.target.files[0].name;
                document.querySelector('.upload-area p').textContent = fileName;
            }
        });