        
<!-- Modal Structure -->
<div id="cvModal" style="display:none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.7);">
    <div style="background-color: #fff; margin: 50px auto; padding: 20px; border-radius: 10px; width: 80%; max-width: 700px; max-height: 90vh; overflow-y: auto;">
        
        <!-- Close Button -->
        <span onclick="closeModal()" style="float:right; font-size:24px; font-weight:bold; cursor:pointer;">&times;</span>
         <!-- Download Button -->
         <a href="{{ asset('images/cv/fazlielahi-cv.zip') }}" download style="display: inline-block; margin-bottom: 15px; padding: 8px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;">
            Download CV
        </a>
        <!-- CV Image Pages -->
        <img src="{{ asset('images/cv/fazlielahi-cv-p1.jpg') }}" alt="CV Page 1" style="width: 100%; margin-bottom: 20px;" />
        <img src="{{ asset('images/cv/fazlielahi-cv-p2.jpg') }}" alt="CV Page 2" style="width: 100%;" />
        <img src="{{ asset('images/cv/fazlielahi-cover-letter.jpg') }}" alt="CV Page 2" style="width: 100%;" />
         <!-- Scroll to Top Arrow -->
        <div id="scrollTopBtn" onclick="scrollToTop()" 
             style="display: none; position: absolute; bottom: 20px; right: 20px; background: #4e54c8; color: white; padding: 10px 15px; border-radius: 50%; cursor: pointer; font-size: 18px;">
            ↑
        </div>
    </div>
</div>


<script>
    function openModal() {
        document.getElementById("cvModal").style.display = "block";

        // Attach scroll event AFTER modal is shown
        const modalContent = document.getElementById("modalContent");
        const scrollBtn = document.getElementById("scrollTopBtn");

        modalContent.addEventListener("scroll", () => {
            if (modalContent.scrollTop > 200) {
                scrollBtn.style.display = "block";
            } else {
                scrollBtn.style.display = "none";
            }
        });
    }

    function closeModal() {
        document.getElementById("cvModal").style.display = "none";
    }

    function scrollToTop() {
        document.getElementById("modalContent").scrollTo({
            top: 0,
            behavior: "smooth"
        });
    }
</script>

