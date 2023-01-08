/**
 * Address Toolkit.
 *
 * Loads Google Maps API and initializes autocomplete on address fields.
 */
(function ($) {
	"use strict";

	const init = () => {
		const addressTypes = ["billing", "shipping"];

		for (let addressType of addressTypes) {
			let country = $(`#${addressType}_country`);
			const state = $(`#${addressType}_state`);
			const city = $(`#${addressType}_city`);
			const postcode = $(`#${addressType}_postcode`);

			// Initialize Autocomplete on Address 1.
			const address = new google.maps.places.Autocomplete(
				$(`#${addressType}_address_1`)[0],
				{
					types: ["address"],
					fields: ["address_component"],
				}
			);

			// Only display for US and CA.
			country.on("change", function () {
				const countryVal = country.val();

				if (!countryVal) {
					countryVal = addresskit_vars.geo_country;
				}

				if (!countryVal || !["US", "CA"].includes(countryVal)) {
					return;
				}

				address.setComponentRestrictions({
					country: countryVal,
				});
			});

			country.trigger("change");

			google.maps.event.addListener(
				address,
				"place_changed",
				function () {
					let place = address.getPlace();
					let address2 = "";
					let address1 = "";

					for (let i = 0; i < place.address_components.length; i++) {
						if (
							place.address_components[i].types[0] ==
							"street_number"
						) {
							address1 = place.address_components[i].long_name;
						} else if (
							place.address_components[i].types[0] == "route"
						) {
							address2 = place.address_components[i].long_name;
						} else if (
							place.address_components[i].types[0] ==
								"sublocality_level_1" ||
							place.address_components[i].types[0] == "locality"
						) {
							city.val(place.address_components[i].long_name);
						} else if (
							place.address_components[i].types[0] ==
								"administrative_area_level_2" ||
							place.address_components[i].types[0] ==
								"administrative_area_level_3"
						) {
							if (
								city.val() == "" &&
								place.address_components[i].types[0] ==
									"administrative_area_level_1"
							) {
								city.val(place.address_components[i].long_name);
							}
						} else if (
							place.address_components[i].types[0] == "country"
						) {
							country.val(place.address_components[i].short_name);
							country.trigger("change");
						} else if (
							place.address_components[i].types[0] ==
							"postal_code"
						) {
							postcode.val(place.address_components[i].long_name);
						}

						if (
							place.address_components[i].types[0] ==
							"administrative_area_level_1"
						) {
							const stateShort =
								place.address_components[i].short_name;
							const stateLong =
								place.address_components[i].long_name;

							setTimeout(function () {
								if (state.prop("tagName") == "SELECT") {
									state.val(stateShort);
									state.find("option").each(function () {
										if (stateShort == $(this).text()) {
											$(this).prop("selected", true);
											return true;
										}
									});
									state.trigger("change");
								} else {
									state.val(stateLong);
								}
							}, 100);
						}
					}

					// Populate address.
					$(`#${addressType}_address_1`).val(
						address1 + " " + address2
					);
				}
			);
		}
	};

	/**
	 * Only display autocomplete when user entered a number.
	 *
	 * @param addressType
	 */
	const maybeHideDropdown = (addressType) => {
		const address = $(`#${addressType}_address_1`).val();
		const country = $(`#${addressType}_country`).val();
		const hasNumber = /\d/;
		const longEnough = 10 < address.length;

		// The country is not US or CA. Hide the autocomplete.
		if (!["US", "CA"].includes(country)) {
			$("body").addClass("hide-autocomplete");
			return;
		}

		// If there is a number in the address or there is more than X characters.
		if (hasNumber.test(address) || longEnough) {
			$("body").removeClass("hide-autocomplete");
		} else {
			$("body").addClass("hide-autocomplete");
		}
	};

	$(document).ready(function () {
		// Run init if we find any of the address fields on the page.
		if (
			$("#billing_address_1").length > 0 ||
			$("#shipping_address_1").length > 0
		) {
			google.maps.event.addDomListener(window, "load", init);
		}

		$("body")
			.on("input focus", "#billing_address_1", function () {
				maybeHideDropdown("billing");
			})
			.on("input focus", "#shipping_address_1", function () {
				maybeHideDropdown("shipping");
			})
			// Focus out.
			.on("blur", "#shipping_address_1, #billing_address_1", function () {
				$("body").removeClass("hide-autocomplete");
			});
	});
})(jQuery);
