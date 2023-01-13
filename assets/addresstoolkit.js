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
			// Scoping the fields help reduce API charges.
			fields: ["address_component"],
		});

		// If the country value field is set, we'll only return results from that country.
		this.setCountryRestriction(address, fieldInputs.country.value);

		// If the country selector is a select2 field, we need to use jQuery to listen for changes.
		if (window.jQuery) {
			jQuery(`#${type}_country`).on("change", () => {
				this.setCountryRestriction(address, fieldInputs.country.value);
			});
		} else {
			fieldInputs.country.addEventListener("change", () => {
				this.setCountryRestriction(address, fieldInputs.country.value);
			});
		}

		// Listen for an autocomplete selection and set new values.
		google.maps.event.addListener(address, "place_changed", () => {
			this.parsePlace(address, fieldInputs);
		});
	};

	setCountryRestriction = (address, country) => {
		if (!country) {
			return;
		}

		// If autocomplete is restricted to specific countries,
		// return early if the selected country is not in the list.
		// @TODO

		address.setComponentRestrictions({
			country: country,
		});
	};

	parsePlace = (address, fieldInputs) => {
		console.log("place change");
		let place = address.getPlace();
		let streetNumber = "";
		let route = "";
		console.log(place);

		for (let i = 0; i < place.address_components.length; i++) {
			const type = place.address_components[i].types[0];
			const shortName = place.address_components[i].short_name;
			const longName = place.address_components[i].long_name;
			console.log(type, shortName, longName);

			// Street number.
			if (type === "street_number") {
				streetNumber = longName;
				continue;
			}

			// Street name.
			if (type === "route") {
				route = longName;
				continue;
			}

			// City.
			if (type === "sublocality_level_1" || type === "locality") {
				fieldInputs.city.value = longName;
				continue;
			}

			// State.
			if (type === "administrative_area_level_1") {
				const stateField = fieldInputs.state;
				if (stateField.tagName == "SELECT") {
					stateField.value = shortName;
					Array.prototype.forEach.call(
						stateField.options,
						function (option) {
							if (shortName == option.value) {
								option.selected = true;
								return true;
							}
						}
					);
				} else {
					stateField.value = longName;
				}
				stateField.dispatchEvent(new Event("change"));
				continue;
			}

			// Country.
			if (type === "country") {
				const countryField = fieldInputs.country;
				countryField.value = shortName;
				countryField.dispatchEvent(new Event("change"));
				continue;
			}

			// Postal code.
			if (type === "postal_code") {
				fieldInputs.postcode.value = longName;
				continue;
			}
		}

		// Populate address1 field.
		fieldInputs.address1.value = streetNumber + " " + route;
	};
}

new AddressToolkit();
