// Page loading animation

document.addEventListener("DOMContentLoaded", function(){

    console.log("Yunicon Tech Website Loaded");

});


// Button hover message

const buttons = document.querySelectorAll(".btn");

buttons.forEach(button => {

    button.addEventListener("mouseenter", function(){

        button.style.transform = "scale(1.05)";

    });


    button.addEventListener("mouseleave", function(){

        button.style.transform = "scale(1)";

    });

});


// Simple scroll effect

window.addEventListener("scroll", function(){

    const header = document.querySelector("header");

    if(window.scrollY > 50){

        header.style.boxShadow = "0 0 20px rgba(0,191,255,0.4)";

    }
    else{

        header.style.boxShadow = "none";

    }

});


// ================================================
// Order Now / Cash on Delivery popup for products
// ================================================

document.addEventListener("DOMContentLoaded", function(){

    const productCards = document.querySelectorAll(".detail-card");

    if(productCards.length === 0){
        return;
    }

    productCards.forEach(card => {

        const nameEl  = card.querySelector("h2");
        const priceEl = card.querySelector(".price");

        const name  = nameEl  ? nameEl.innerText  : "Product";
        const price = priceEl ? priceEl.innerText : "";

        const orderBtn = document.createElement("button");
        orderBtn.type = "button";
        orderBtn.className = "order-btn";
        orderBtn.innerText = "🛒 Order Now";

        orderBtn.addEventListener("click", function(){
            openOrderModal(name, price);
        });

        card.appendChild(orderBtn);

    });

    injectOrderModal();

});


function injectOrderModal(){

    const modal = document.createElement("div");
    modal.id = "orderModal";
    modal.className = "order-modal";

    modal.innerHTML = `
        <div class="order-modal-content">

            <span class="order-close" id="orderClose">&times;</span>

            <h2>Place Your Order</h2>

            <p class="order-product-name" id="orderProductName"></p>
            <p class="order-product-price" id="orderProductPrice"></p>

            <form id="orderForm">

                <label for="custName">Full Name</label>
                <input type="text" id="custName" required placeholder="Enter your full name">

                <label for="custPhone">Phone Number</label>
                <input type="tel" id="custPhone" required placeholder="07X XXX XXXX">

                <label for="custAddress">Delivery Address</label>
                <textarea id="custAddress" required placeholder="House No, Street, City"></textarea>

                <label class="payment-label">Payment Method</label>

                <div class="payment-option">
                    <input type="radio" id="cod" name="payment" value="Cash on Delivery" checked>
                    <label for="cod">💵 Cash on Delivery</label>
                </div>

                <button type="submit" class="btn order-submit-btn">Confirm Order</button>

            </form>

            <div class="order-success" id="orderSuccess">
                ✅ Order placed successfully!<br>
                We will call you shortly to confirm delivery via <strong>Cash on Delivery</strong>.
            </div>

        </div>
    `;

    document.body.appendChild(modal);

    document.getElementById("orderClose").addEventListener("click", closeOrderModal);

    modal.addEventListener("click", function(e){
        if(e.target === modal){
            closeOrderModal();
        }
    });

    document.getElementById("orderForm").addEventListener("submit", function(e){

        e.preventDefault();

        const submitBtn = document.querySelector(".order-submit-btn");
        submitBtn.disabled = true;
        submitBtn.innerText = "Placing Order...";

        const orderData = {
            name: document.getElementById("custName").value,
            phone: document.getElementById("custPhone").value,
            address: document.getElementById("custAddress").value,
            product_name: document.getElementById("orderProductName").innerText,
            product_price: document.getElementById("orderProductPrice").innerText,
            payment_method: document.querySelector('input[name="payment"]:checked').value
        };

        fetch("save_order.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(orderData)
        })
        .then(response => response.json())
        .then(data => {

            submitBtn.disabled = false;
            submitBtn.innerText = "Confirm Order";

            if(data.status === "success"){

                document.getElementById("orderForm").style.display = "none";
                document.getElementById("orderSuccess").style.display = "block";

                setTimeout(function(){
                    closeOrderModal();
                    resetOrderModal();
                }, 3000);

            } else {
                alert("Order failed: " + data.message);
            }

        })
        .catch(error => {
            submitBtn.disabled = false;
            submitBtn.innerText = "Confirm Order";
            alert("Something went wrong. Please check your internet/server and try again.");
            console.error(error);
        });

    });

}


function openOrderModal(name, price){

    document.getElementById("orderProductName").innerText = name;
    document.getElementById("orderProductPrice").innerText = price;

    document.getElementById("orderModal").classList.add("active");
    document.body.style.overflow = "hidden";

}


function closeOrderModal(){

    document.getElementById("orderModal").classList.remove("active");
    document.body.style.overflow = "auto";

}


function resetOrderModal(){

    document.getElementById("orderForm").reset();
    document.getElementById("orderForm").style.display = "block";
    document.getElementById("orderSuccess").style.display = "none";

}