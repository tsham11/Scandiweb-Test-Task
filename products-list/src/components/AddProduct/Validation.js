import axios from 'axios';

export const validateFormData = async (formData, setErrors) => {
  const newErrors = {};

  // Check required fields
  if (!formData.sku) newErrors.sku = 'Please, submit required data';
  if (!formData.name) newErrors.name = 'Please, submit required data';
  if (!formData.price || isNaN(formData.price)) newErrors.price = 'Please, submit required data';
  if (!formData.productType) newErrors.productType = 'Please, submit required data';

  const productTypeValidation = {
    DVD: () => {
      if (!formData.size || isNaN(formData.size)) newErrors.size = 'Please, provide the data of indicated type';
    },
    Book: () => {
      if (!formData.weight || isNaN(formData.weight)) newErrors.weight = 'Please, provide the data of indicated type';
    },
    Furniture: () => {
      if (!formData.height || isNaN(formData.height)) newErrors.height = 'Please, provide the data of indicated type';
      if (!formData.width || isNaN(formData.width)) newErrors.width = 'Please, provide the data of indicated type';
      if (!formData.length || isNaN(formData.length)) newErrors.length = 'Please, provide the data of indicated type';
    }
  };

  const validateProductType = productTypeValidation[formData.productType];
  if (validateProductType) validateProductType();

  setErrors(newErrors);
  if (Object.keys(newErrors).length === 0) {
    return await checkSkuUnique(formData.sku, setErrors);
  }
  return false;
};

const checkSkuUnique = async (sku, setErrors) => {
  try {
    const response = await axios.post('https://localhost/Backend-Products/check-sku.php', { sku });
    if (response.data.unique) {
      return true;
    } else {
      setErrors((prevErrors) => ({ ...prevErrors, sku: 'SKU already exists' }));
      return false;
    }
  } catch (error) {
    console.error('Error checking SKU uniqueness', error);
    return false;
  }
};
