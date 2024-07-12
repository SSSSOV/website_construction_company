const exampleModal = document.getElementById('exampleModal')
if (exampleModal) {
  exampleModal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const recipient = button.getAttribute('data-bs-whatever')
    // If necessary, you could initiate an Ajax request here
    // and then do the updating in a callback.

    // Update the modal's content.
    const modalTitle = exampleModal.querySelector('.modal-title')
    const modalBodyInput = exampleModal.querySelector('.modal-body input')

    modalTitle.textContent = 'Заявка'
    modalBodyInput.value = recipient
  })
}

document.getElementById('sendButton').addEventListener('click', function () {
    const recipient = document.getElementById('recipient-name').value;
    const phone = document.getElementById('phone-number').value;
    const message = document.getElementById('message-text').value;

    fetch('send_mail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            recipient: recipient,
            phone: phone,
            message: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Сообщение успешно отправлено!');
            document.getElementById('contactForm').reset();
            var modalEl = document.getElementById('exampleModal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
        } else {
            alert('Ошибка при отправке сообщения.');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('Ошибка при отправке сообщения.');
    });
});
