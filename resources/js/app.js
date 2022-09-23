import jQuery from 'jquery';
window.$ = jQuery;

import { valuesIn } from 'lodash';
import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    if(route().current() == 'home') {
        show_companies(1);
    }

    //console.log(userAuthenticated());
    //console.log(getUserID());
});

function userAuthenticated() {
    const authenticated = document.querySelector('#authenticated').value;
    return Boolean(authenticated);
}

function getUserID() {
    if(userAuthenticated()) {
        if(document.querySelector('#userID')) {
            return parseInt(document.querySelector('#userID').value);
        }
    }
    return 0;
}

window.show_companies = function(page=1) {
    var container = document.querySelector('#container_companies');
    container.innerHTML = '';

    fetch(route('api_companies', page))
    .then(response => response.json())
    .then(data => {
        if(Object.keys(data.data).length > 0) {
            data.data.forEach(company => {
                const element = document.createElement('div');
				element.className = 'container p-4 my-3 border';
                element.innerHTML = `
                    <h4 class="text-center"><a href="${route('view_company', company.id)}">${company.name}</a></h4>
                    <div class="text-center">
                        <img src="${company.image_url}" height="100px" width="100px" alt="https://static.thenounproject.com/png/194055-200.png">
                    </div>
                    <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; line-clamp: 2; -webkit-box-orient: vertical;">${company.description}</p>
                    <p style="float: right;">Created by ${company.created_by_user.name}</p>
                    <i id="like_button" style="float: left;" class="fa-regular fa-heart"> ${company.likes_amount} likes</i>
                `;

				const element_like_button = element.querySelector('#like_button');

                if(userAuthenticated()) {
                    element_like_button.style.cursor = 'pointer';

                    if(company.likes.includes(getUserID())) {
                    	element_like_button.className = 'fa-solid fa-heart';
                    	element_like_button.style.color = 'red';
                    }

                    element_like_button.addEventListener('click', function() {
                        fetch(route('api_like'), {
                			method: 'POST',
    							body: JSON.stringify({
    							    user_id: getUserID(),
            					    company_id: company.id
            				    }),
                                headers: {
                                    'Content-Type': 'application/json',
                                    "X-CSRF-Token": document.head.querySelector("[name~=csrf-token][content]").content
                                }
              			    })
              			    .then(response => response.json())
    					    .then(result => {
    						    if(result.error === "security") {
    							    alert("You can't like posts for other users!");
    							    location.reload();
    						    } else if(result.action === "like") {
    							    this.className = 'fa-solid fa-heart';
								    this.style.color = 'red';
								    this.innerText = ' ' + result.likes_amount + ' likes';
    						    } else if(result.action === "unlike") {
    							    this.className = 'fa-regular fa-heart';
								    this.style.color = 'black';
								    this.innerText = ' ' + result.likes_amount + ' likes';
    						    }
    					    });
                        });
                }

                container.append(element);
            });

            const pagination_container = document.createElement('div');
        	pagination_container.innerHTML = `<nav><ul id="pagination" class="pagination justify-content-center"></ul></nav>`;
			container.append(pagination_container);

			const pagination = pagination_container.querySelector('#pagination');

            data.links.forEach(val => {
                const pagination_button = document.createElement('li');
                const button_active = val.active == true ? "active" : "";

                if(val.label == '&laquo; Previous') {
                    if(data.prev_page_url) {
                        var button_event = `show_companies(${data.prev_page_url.split("?page=")[1]});`;
                    } else {
                        var button_event = "";
                    }
                } else if(val.label == 'Next &raquo;') {
                    if(data.next_page_url) {
                        var button_event = `show_companies(${data.next_page_url.split("?page=")[1]});`;
                    } else {
                        var button_event = "";
                    }
                } else {
                    var button_event = `show_companies(${val.label});`;
                }

                pagination_button.innerHTML = `<li class="page-item ${button_active}"><a onclick="${button_event}" class="page-link" href="javascript:void(0);">${val.label}</a></li>`;
                
                pagination.append(pagination_button);
            });
        } else {
            const element = document.createElement('div');
			
            element.className = 'container p-4 my-3 border';
            element.innerHTML = `
                <h2 class="text-center">No companies yet...</h2>
            `;

            container.append(element);
        }
    });
}
