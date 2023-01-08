/**
 * Address Toolkit.
 *
 * Loads Google Maps API and initializes autocomplete on address fields.
 */
class AddressToolkit {
	constructor() {
		document.addEventListener("DOMContentLoaded", this.initFields, false);
	}

	initFields = () => {
		console.log("init");
		const billingField = document.getElementById("billing_address_1");
		if (billingField) {
			this.initAutocomplete(billingField, "billing");
		}

		const shippingField = document.getElementById("shipping_address_1");
		if (shippingField) {
			this.initAutocomplete(billingField, "shipping");
		}
	};

	initAutocomplete = (field, type) => {
		console.log(field, type);
		const country = document.getElementById(`${type}_country`);
		const state = document.getElementById(`${type}_state`);
		const city = document.getElementById(`${type}_city`);
		const postcode = document.getElementById(`${type}_postcode`);
	};
}

new AddressToolkit();
