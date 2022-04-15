
import { createStore } from "vuex";
import { auth } from "./auth.module";
import { user } from "./user.module";
import { customer } from "./customer.module";
import { bill } from "./bill.module";
const store = createStore({
  modules: {
    auth,
    user,
    customer,
    bill,
  },
});
export default store;
