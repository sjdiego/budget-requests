let mutations = {
    setDescription(state, description) {
        state.description = description
    },
    setEstimatedDates(state, estimatedDates) {
        state.estimatedDates = estimatedDates
    },
    setEstimatedDate(state, estimatedDate) {
        state.estimatedDate = estimatedDate
    },
    setCategories(state, categories) {
        state.categories = categories
    },
    setCategory(state, category) {
        state.category = category
    },
    setSubcategories(state, subcategories) {
        state.subcategories = subcategories
    },
    setSubcategory(state, subcategory) {
        state.subcategory = subcategory
    },
    setDesiredPrices(state, desiredPrices) {
        state.desiredPrices = desiredPrices
    },
    setDesiredPrice(state, desiredPrice) {
        state.desiredPrice = desiredPrice
    },
    setName(state, name) {
        state.name = name
    },
    setEmail(state, email) {
        state.email = email
    },
    setPhone(state, phone) {
        state.phone = phone
    }
};

export default mutations
