import { useEffect, useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import './ProductList.css';

function ProductList() {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  useEffect(() => {
    axios.get('https://localhost/Backend-Products/get-products.php')
      .then(response => {
        setProducts(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the data!', error);
      });
  }, []);

  const handleMassDelete = () => {
    setLoading(true);
    const selectedProducts = products.filter(product => product.selected).map(product => product.sku);

    axios.post('https://localhost/Backend-Products/delete.php', { products: selectedProducts })
      .then(response => {
        if (response.data.success) {
          setProducts(products.filter(product => !selectedProducts.includes(product.sku)));
        } else {
          console.error('There was an error deleting the products!', response.data.error);
        }
        setLoading(false);
      })
      .catch(error => {
        console.error('There was an error deleting the products!', error);
        setLoading(false);
      });
  };

  const handleCheckboxChange = (sku) => {
    setProducts(products.map(product =>
      product.sku === sku ? { ...product, selected: !product.selected } : product
    ));
  };

  return (
    <div className='container'>
      <div className='header'>
        <h1>Product List</h1>
        <div className="buttons">
          <button onClick={() => navigate('/add-product')}>ADD</button>
          <button onClick={handleMassDelete} disabled={loading}>MASS DELETE</button>
        </div>
      </div>

      {loading && <div className="loading">Deleting...</div>}

      <form method="post">
        <div className="product-grid">
          {products.map(product => (
            <div className="product" key={product.sku}>
              <input
                type="checkbox"
                name="products[]"
                value={product.sku}
                className="delete-checkbox"
                checked={product.selected || false}
                onChange={() => handleCheckboxChange(product.sku)}
              />
              <p>{product.sku}</p>
              <p>{product.name}</p>
              <p>{product.price} $</p>
              <p>{product.attribute}</p>
            </div>
          ))}
        </div>
      </form>

      <div className="footer">
        <h2>Scandiweb Test assignment</h2>
      </div>
    </div>
  );
}

export default ProductList;
