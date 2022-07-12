/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
require('bootstrap');

// start the Stimulus application
import './bootstrap';

window.addEventListener('load', () => {
    const borrowBtn = document.getElementById('borrow_btn');
    if(borrowBtn) {
        borrowBtn.addEventListener('click', function () {
            const bookId = document.getElementById('bookId').value;
            fetch('/book/borrow/' + bookId)
            .then(response => response.text())
            .then((text) => {
                const bookListPanel = document.getElementById('bookListPanel');
                bookListPanel.innerHTML += '<span class="border p-2">' + text + '</span>';
            })
        });
    }
});
