document.addEventListener('DOMContentLoaded', function () {

    const checkboxes = document.querySelectorAll('.brand-filter');

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {

            const selected = Array.from(checkboxes)
                .filter(c => c.checked)
                .map(c => c.value);

            const url = new URL(window.location.href);

            if (selected.length > 0) {
                url.searchParams.set('nsx', selected.join(','));
            } else {
                url.searchParams.delete('nsx');
            }

            url.searchParams.delete('page'); // 🔥 luôn về page 1
            window.location.href = url.toString(); // reload có kiểm soát
        });
    });

});
