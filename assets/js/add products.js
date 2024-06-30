document.getElementById('showAddProductFormButton').addEventListener('click', () => {
    const form = document.getElementById('addProductForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
});
