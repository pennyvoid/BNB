export default {
    state: {
        lastSearch: {
            from: null,
            to: null
        },
        basket: {
            items: []
        }
    },
    mutations: {
        setLastSearch(state, payload) {
            state.lastSearch = payload;
        },
        addToBasket(state, payload) {
            state.basket.items.push(payload);
        },
        removeFromBasket(state, playload) {
            state.basket.items = state.basket.items.filter(
                item => item.bookable.id != playload
            );
        },
        setBasket(state, payload) {
            state.basket = payload;
        }
    },
    actions: {
        setLastSearch(context, payload) {
            context.commit("setLastSearch", payload);
            localStorage.setItem("lastSearch", JSON.stringify(payload));
        },
        loadStoredState(context) {
            const lastSearch = localStorage.getItem("lastSearch");
            if (lastSearch) {
                context.commit("setLastSearch", JSON.parse(lastSearch));
            }
            const basket = localStorage.getItem("basket");
            if (basket) {
                context.commit("setBasket", JSON.parse(basket));
            }
        },
        addToBasket({ commit, state }, payload) {
            // context.state, context.commit
            commit("addToBasket", payload);
            localStorage.setItem("basket", JSON.stringify(state.basket));
        },
        removeFromBasket({ commit, state }, payload) {
            commit("removeFromBasket", payload);
            localStorage.setItem("basket", JSON.stringify(state.basket));
        }
    },
    getters: {
        itemsInBasket: state => state.basket.items.length,
        alreadyInBasket(state) {
            return id => {
                return state.basket.items.reduce(
                    (response, item) => response || item.bookable.id === id,
                    false
                );
            };
        }
    }
};
