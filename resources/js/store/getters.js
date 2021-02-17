let getters = {
    description: state => state.description,
    estimatedDates: state => state.estimatedDates,
    estimatedDate: state => state.estimatedDate,
    categories: state => state.categories,
    category: state => state.category,
    subcategories: state => state.subcategories,
    subcategory: state => state.subcategory,
    desiredPrices: state => state.desiredPrices,
    desiredPrice: state => state.desiredPrice,
    name: state => state.name,
    phone: state => state.phone,
    email: state => state.email
};

export default getters
