$(function(){
    const arrImages = [
        {
            src : "images/certificates/masia/web-masia.jpg",
            desc : "<span class='description'> <u>Fullstack WEB development certificate</u> MASIA Institute Rawalpindi</span>"
        },
        {
            src : "images/certificates/leeds/english-teaching-certificate.jpg",
            desc : "<span class='description'> <u>Teaching English Language certificate</u> LEEDS english language and computer Institute</span>"
        },
        {
            src : "images/certificates/leeds/english-language-ceretificate.jpg",
            desc : "<span class='description'> <u>English Language certificate</u> LEEDS english language and computer Institute</span>"
        },
        {
            src : "images/certificates/leeds/autocade-certificate.jpg",
            desc : "<span class='description'> <u>Auto CAD 2D + 3D certificate</u> LEEDS english language and computer Institute</span>"
        },
        {
            src : "images/certificates/leeds/ms-office-certificate.jpg",
            desc : "<span class='description'> <u>Office Automation certificate</u> LEEDS english language and computer Institute</span>"
        },
        {
            src : "images/certificates/college/gpg-dargai.jpg",
            desc : "<span class='description'><u>Character certificate</u> GOVT post graduate college Dargai Malakand </span>"
        },
        {
            src : "images/certificates/school/examination-certificate-ghss-skt.jpg",
            desc : "<span class='description'><u>Secondary school certificate Examination</u> Distt: Malakand </span>"
        },
        {
            src : "images/certificates/school/character-certificate-ghss-skt.jpg",
            desc : "<span class='description'><u>Character certificate</u> GOVT higher cecondary school Distt: Malakand </span>"
        }
    ]
    
    

    const imageSectionContainer = $('.image-section');
    const imageGallery = $(`<div class="image-gallery"></div>`);

    $.each(arrImages, function(key, image){
        let imageSrc = image.src;
        let imageDesc = image.desc;

        let imageLink = $(`
            <a class="card" href="${imageSrc}">
               <div class="image"> <img src="${imageSrc}" alt="gallery-img_${key}" loading="lazy"/> </div>${imageDesc}
            </a>
            `);

        imageLink.on('click', function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            imageLightbox(arrImages, key);
        });

        imageGallery.append(imageLink);
        imageSectionContainer.append(imageGallery);
    });

});
