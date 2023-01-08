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
		const fieldInputs = {
			address1: field,
			city: document.getElementById(`${type}_city`),
			state: document.getElementById(`${type}_state`),
			country: document.getElementById(`${type}_country`),
			postcode: document.getElementById(`${type}_postcode`),
		};

		// Initialize Places Autocomplete on Address 1.
		const address = new google.maps.places.Autocomplete(field, {
			types: ["address"],
			fields: ["address_component"],
		});

		// If the country value field is set, we'll only return results from that country.
		this.setCountryRestriction(address, fieldInputs.country.value);
		fieldInputs.country.addEventListener("change", () => {
			this.setCountryRestriction(address, fieldInputs.country.value);
		});

		// Listen for an autocomplete selection and set new values.
		google.maps.event.addListener(address, "place_changed", () => {
			this.parsePlace(address, fieldInputs);
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

	parsePlace = (address, fieldInputs) => {
		console.log("place change");
		let place = address.getPlace();
		let address1 = "";
		let address2 = "";
		console.log(place);

		for (let i = 0; i < place.address_components.length; i++) {
			const type = place.address_components[i].types[0];
			const shortName = place.address_components[i].short_name;
			const longName = place.address_components[i].long_name;
			console.log(type, shortName, longName);

			if (type === "street_number") {
				address1 = longName;
				continue;
			}

			if (type === "route") {
				address2 = longName;
				continue;
			}

			// City.
			if (type === "sublocality_level_1" || type === "locality") {
				fieldInputs.city.setAttribute("value", longName);
				continue;
			}

			// State.
			if (type === "administrative_area_level_1") {
				// @TODO Set state.
				continue;
			}

			// Country.
			if (type === "administrative_area_level_1") {
				fieldInputs.country.setAttribute("value", shortName);
				// @TODO Trigger change event.
				continue;
			}

			// Postal code.
			if (type === "postal_code") {
				fieldInputs.postcode.setAttribute("value", longName);
				continue;
			}

			// @TODO Populate address 1 field.
		}
	};
}

new AddressToolkit();
