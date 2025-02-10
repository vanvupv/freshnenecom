(function ($, window) {
	// ----- longpv ------
	// ----- vucoder ------
	jQuery(document).ready(function ($) {
		// Tạo một dropdown mới bên cạnh ô số lượng
		$(".quantity").append('<select class="quantity-select"></select>');

		// Lấy các giá trị từ dropdown trong bảng .variations và thêm vào dropdown mới
		$(".variations select").each(function () {
			const $select = $(this); // Dropdown trong bảng .variations
			const $newDropdown = $(".quantity-select"); // Dropdown mới

			// Xử lý khi bảng .variations thay đổi
			$select.on("change", function () {
				const options = $select.html(); // Lấy các tùy chọn
				$newDropdown.html(options); // Đổ các tùy chọn vào dropdown mới
				$newDropdown.val($select.val()); // Đồng bộ giá trị được chọn
			});

			// Đồng bộ khi tải trang
			const initialOptions = $select.html();
			$newDropdown.html(initialOptions);
			$newDropdown.val($select.val());
		});

		// Khi chọn giá trị trong dropdown mới, đồng bộ lại với dropdown trong bảng .variations
		$(".quantity-select").on("change", function () {
			const selectedValue = $(this).val();
			$(".variations select").each(function () {
				$(this).val(selectedValue).trigger("change");
			});
		});
	});

	// Chức năng Wishlist
	$(document).on("click", ".favorite_posts", function (e) {
		e.preventDefault(); // Ngăn chặn hành động mặc định nếu có
		let $this = $(this);
		let post_id = $this.data("post_id");

		$.ajax({
			url: url_ajax,
			type: "POST",
			data: {
				action: "favorite_posts",
				post_id: post_id,
			},
			beforeSend: function () {
				$("body").append(
					'<div id="ajax-loader"><div class="spinner"></div></div>'
				);
			},
			success: function (response) {
				if (response.success) {
					if (response.data.status === "added") {
						$(
							'.favorite_posts[data-post_id="' + post_id + '"]'
						).addClass("active");
					} else if (response.data.status === "removed") {
						$(
							'.favorite_posts[data-post_id="' + post_id + '"]'
						).removeClass("active");
					}
				} else {
					alert(response.data.message);
				}
			},
			error: function () {
				alert("Something went wrong.");
			},
			complete: function () {
				$("body #ajax-loader").remove();
			},
		});
	});
})(jQuery, window);
