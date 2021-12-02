$(window).on("load",function(){function e(o){return new Promise((e,s)=>{$.ajax({url:o,method:"get",dataType:"json"}).done(e).fail(s)})}e("tienda/ajax_get_lines/0").then(e=>{$("#lines-slides").empty(),$.each(e,function(e,s){var o=s.name.replace(/\s+/g,"_");$("#lines-slides").append(`
                <div>
                    <div class='category-wrapper p-1'>
                        <div>    
                            <a href="${s.filter_url}">
                                <div style="height: 160px; overflow: hidden; background-image: url(uploads/online-store/${o}.jpeg); background-size: cover; background-position: center center;">
                                    <img style="height: 100%; display: none;" src="uploads/online-store/${o}.jpeg" alt="${o}">
                                </div>
                                <span class="btn btn-classic btn-outline">${s.name}</span>
                            </a>
                        </div>
                    </div>
                </div>
            `)}),$("#lines-slides").slick({infinite:!1,speed:300,arrows:!0,slidesToShow:6,slidesToScroll:1,autoplaySpeed:5e3,responsive:[{breakpoint:1500,arrows:!0,settings:{slidesToShow:4,slidesToScroll:4}},{breakpoint:1200,arrows:!0,settings:{slidesToShow:3,slidesToScroll:3}},{breakpoint:991,arrows:!0,settings:{slidesToShow:2,slidesToScroll:2}}]})}).catch(e=>{console.log(e)}),e("tienda/ajax_search/0/true").then(e=>{$("#most-new-products").empty(),$.each(e,function(e,s){var o=s.PCTJ_FLETE?parseFloat(s.PCTJ_FLETE)/100:0,i=s.total_with_discount||parseFloat(s.lowest_price),o=s.total_with_discount?i+i*o:s.lowest_price;$("#most-new-products").append(`
                  <div class="product-box product-wrap">
                      <a href="tienda/categoria/${s.url_title}">
                          <div class="img-wrapper" style="height: 149px; overflow: hidden; background-image: url('https://www.berny.mx/uploads/categoriesweb/${s.category_id}.png'); background-size: cover; background-position: center center;">
                              <div class="front">
                                  <span style="background-size:contain; background-repeat: no-repeat;" href="tienda/categoria/${s.url_title}">
                                      <img src="https://www.berny.mx/uploads/categoriesweb/${s.category_id}.png"  style="height: 100%; display: none;" alt="${s.category_id}">
                                  </span>
                              </div>
                          </div>
                          <div class="product-info">
                              <a href="tienda/categoria/${s.url_title}">
                                  <h6>
                                      ${s.category_name}
                                      <small>${s.number_products||""}</small>
                                  </h6>
                              </a>
                              <div><small >Precios Desde $${parseFloat(o).toFixed(2)} IVA incluido*</small></div>
                          </div>
                      </a>
                  </div>
              `)}),$("#most-new-products").slick({infinite:!1,speed:300,arrows:!0,slidesToShow:5,slidesToScroll:1,autoplaySpeed:5e3,responsive:[{breakpoint:1500,arrows:!0,settings:{slidesToShow:4,slidesToScroll:4}},{breakpoint:1200,arrows:!0,settings:{slidesToShow:3,slidesToScroll:3}},{breakpoint:991,arrows:!0,settings:{slidesToShow:2,slidesToScroll:2}}]})}).catch(e=>{console.log(e)}),e("tienda/ajax_search/0/relevantes/true").then(e=>{$("#most-relevant-products").empty(),$.each(e,function(e,s){var o=s.PCTJ_FLETE?parseFloat(s.PCTJ_FLETE)/100:0,i=s.total_with_discount||parseFloat(s.lowest_price),o=s.total_with_discount?i+i*o:s.lowest_price;$("#most-relevant-products").append(`
                  <div class="product-box product-wrap">
                      <a href="tienda/categoria/${s.url_title}">
                          <div class="img-wrapper" style="height: 149px; overflow: hidden; background-image: url('https://www.berny.mx/uploads/categoriesweb/${s.category_id}.png'); background-size: cover; background-position: center center;">
                              <div class="front">
                                  <span style="background-size:contain; background-repeat: no-repeat;" href="tienda/categoria/${s.url_title}">
                                      <img alt="${s.category_id}" src="https://www.berny.mx/uploads/categoriesweb/${s.category_id}.png"  style="height: 100%; display: none;">
                                  </span>
                              </div>
                          </div>
                          <div class="product-info">
                              <a href="tienda/categoria/${s.url_title}">
                                  <h6>
                                      ${s.category_name}
                                      <small>${s.number_products||""}</small>
                                  </h6>
                              </a>
                              <div><small >Precios Desde $${parseFloat(o).toFixed(2)} IVA incluido*</small></div>
                          </div>
                      </a>
                  </div>
              `)}),$("#most-relevant-products").slick({infinite:!1,speed:300,arrows:!0,slidesToShow:5,slidesToScroll:1,autoplaySpeed:5e3,responsive:[{breakpoint:1500,arrows:!0,settings:{slidesToShow:4,slidesToScroll:4}},{breakpoint:1200,arrows:!0,settings:{slidesToShow:3,slidesToScroll:3}},{breakpoint:991,arrows:!0,settings:{slidesToShow:2,slidesToScroll:2}}]})}).catch(console.log),e("tienda/ajax_get_groups/0").then(e=>{$("#groups-slider").empty(),$.each(e,function(e,s){var o=s.name.split(" "),s='<div><div class="category-block"><a href='+s.filter_url+'><div class="category-image"><img height="40" alt="'+s.image+'" src="https://www.berny.mx/'+s.image+'"></div></a><div class="category-details"><a href="#"><h5>'+o[0];o[1]&&(s+="<br>"+o[1]),s+="</h5></a></div></div></div>",$("#groups-slider").append(s)}),$("#groups-slider").slick({dots:!0,arrows:!0,infinite:!0,speed:300,slidesToShow:6,slidesToScroll:6,responsive:[{breakpoint:1367,settings:{slidesToShow:5,arrows:!0,slidesToScroll:5,infinite:!0}},{breakpoint:1024,settings:{slidesToShow:4,slidesToScroll:4,arrows:!0,infinite:!0}},{breakpoint:767,settings:{slidesToShow:3,slidesToScroll:3,arrows:!0,infinite:!0}},{breakpoint:480,settings:{slidesToShow:2,arrows:!0,slidesToScroll:2}}]})}).catch(console.log)});