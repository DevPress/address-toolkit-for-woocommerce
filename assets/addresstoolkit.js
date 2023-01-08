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
		const billingField = document.getElementById("billing_address_1");
		if (billingField) {
			this.initAutocomplete(billingField, "billing");
		}

		const shippingField = document.getElementById("shipping_address_1");
		if (shippingField) {
			this.initAutocomplete(shippingField, "shipping");
		}
	};

	initAutocomplete = (field, type) => {
		const country = document.getElementById(`${type}_country`);
		const state = document.getElementById(`${type}_state`);
		const city = document.getElementById(`${type}_city`);
		const postcode = document.getElementById(`${type}_postcode`);

		// Initialize Places Autocomplete on Address 1.
		const address = new google.maps.places.Autocomplete(field, {
			types: ["address"],
			fields: ["address_component"],
		});

		// If the country value field is set, we'll only return results from that country.
		this.setCountryRestriction(address, country.value);
		country.addEventListener("change", () => {
			this.setCountryRestriction(address, country.value);
		});

		// Listen for an autocomplete selection.
		google.maps.event.addListener(address, "place_changed", () => {
			this.parsePlace(address);
		});
	};

	setCountryRestriction = (address, country) => {
		if (!country) {
			return;
		}

		// @TODO This is where we could include or exclude countries based on user settings.

		address.setComponentRestrictions({
			country: country,
		});
	};

	parsePlace = (address) => {
		console.log("place change");
		let place = address.getPlace();
		let address1 = "";
		let address2 = "";
		console.log(place);

		for (let i = 0; i < place.address_components.length; i++) {
			const type = place.address_components[i].types[0];
			console.log(type);
		}
	};
}

new AddressToolkit();
