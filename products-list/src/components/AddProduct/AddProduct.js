import { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import './AddProduct.css';
import { validateFormData } from './Validation.js';

function AddProduct (){
  const [formData, setFormData] = useState({
    sku: '',
    name: '',
    price: '',
    productType: '',
    size: '',
    weight: '',
    height: '',
    width: '',
    length: ''
  });
  const [errors, setErrors] = useState({});
  const navigate = useNavigate();

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (await validateFormData(formData, setErrors)) {
      axios.post('https://localhost/Backend-Products/save-product.php', formData)
        .then(response => {
          if (response.data.success) {
            navigate('/');
          } else {
            console.error('There was an error saving the product:', response.data.error);
          }
        })
        .catch(error => {
          console.error('There was an error saving the product!', error);
        });
    }
  };

  const productTypeFields = {
    DVD: (
      <>
        <label htmlFor="size">Size (MB)</label>
        <input
          type="text"
          id="size"
          name="size"
          onChange={handleChange}
          value={formData.size}
        />
        {errors.size && <p className="error">{errors.size}</p>}
        <p>Please, provide size</p>
      </>
    ),
    Book: (
      <>
        <label htmlFor="weight">Weight (KG)</label>
        <input
          type="text"
          id="weight"
          name="weight"
          onChange={handleChange}
          value={formData.weight}
        />
        {errors.weight && <p className="error">{errors.weight}</p>}
        <p>Please, provide weight</p>
      </>
    ),
    Furniture: (
      <>
        <label htmlFor="height">Height (CM)</label>
        <input
          type="text"
          id="height"
          name="height"
          onChange={handleChange}
          value={formData.height}
        />
        {errors.height && <p className="error">{errors.height}</p>}

        <label htmlFor="width">Width (CM)</label>
        <input
          type="text"
          id="width"
          name="width"
          onChange={handleChange}
          value={formData.width}
        />
        {errors.width && <p className="error">{errors.width}</p>}

        <label htmlFor="length">Length (CM)</label>
        <input
          type="text"
          id="length"
          name="length"
          onChange={handleChange}
          value={formData.length}
        />
        {errors.length && <p className="error">{errors.length}</p>}
        <p>Please, provide dimensions</p>
      </>
    )
  };

  return (
    <div className='container'>
      <div className='header'>
        <h1>Add Product</h1>
        <div className="buttons">
          <button type="submit" form="product_form">Save</button>
          <button type="button" onClick={() => navigate('/')}>Cancel</button>
        </div>
      </div>

      <form id="product_form" onSubmit={handleSubmit}>
        <label htmlFor="sku">SKU</label>
        <input
          type="text"
          id="sku"
          name="sku"
          onChange={handleChange}
          value={formData.sku}
        />
        {errors.sku && <p className="error">{errors.sku}</p>}

        <label htmlFor="name">Name</label>
        <input
          type="text"
          id="name"
          name="name"
          onChange={handleChange}
          value={formData.name}
        />
        {errors.name && <p className="error">{errors.name}</p>}

        <label htmlFor="price">Price ($)</label>
        <input
          type="text"
          id="price"
          name="price"
          onChange={handleChange}
          value={formData.price}
        />
        {errors.price && <p className="error">{errors.price}</p>}

        <label htmlFor="productType">Type Switcher</label>
        <select
          id="productType"
          name="productType"
          onChange={handleChange}
          value={formData.productType}
        >
          <option value="">Select Type</option>
          <option value="DVD">DVD</option>
          <option value="Book">Book</option>
          <option value="Furniture">Furniture</option>
        </select>
        {errors.productType && <p className="error">{errors.productType}</p>}

        {productTypeFields[formData.productType]}
      </form>

      <div className="footer">
        <h2>Scandiweb Test assignment</h2>
      </div>
    </div>
  );
};

export default AddProduct;
