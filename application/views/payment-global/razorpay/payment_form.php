<?php
//start common code of all payment gateway
if ($payment_details['is_instructor_payout_user_id'] > 0) {
  $instructor_details = $this->user_model->get_all_user($payment_details['is_instructor_payout_user_id'])->row_array();
  $keys = json_decode($instructor_details['payment_keys'], true);
  $keys = $keys[$payment_gateway['identifier']];
} else {
  $keys = json_decode($payment_gateway['keys'], true);
}
$test_mode = $payment_gateway['enabled_test_mode'];
//ended common code of all payment gateway

// Convert the total payable amount to an integer value (assuming it's in INR)
$total_payable_amount = intval($payment_details['total_payable_amount'] * 100);
?>
<button id="rzp-button1" class="payment-button float-end gateway <?php echo $payment_gateway['identifier']; ?>-gateway"><i class="fas fa-money-bill"></i> <?php echo get_phrase('pay_by_razorpay'); ?></button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  var options = {
    "key": "<?php echo $keys['key_id']; ?>", // Enter the Key ID generated from the Dashboard
    "amount": <?php echo $total_payable_amount; ?>, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "<?php echo $payment_gateway['currency']; ?>",
    "description": "<?php echo $payment_details['payment_title']; ?>",
    "image": "https://s3.amazonaws.com/rzp-mobile/images/rzp.jpg",
    config: {
      display: {
        blocks: {
          utib: {
            name: 'Pay using Axis banks',
            instruments: [{
                method: 'netbanking',
                banks: ['UTIB'],
              },
              {
                method: 'card',
                issuers: ['UTIB'],
              },
              {
                method: 'wallet',
                wallets: ['payzapp']
              }
            ],
          },
          walletfreecharge: {
            name: 'Methods with Offers',
            instruments: [{
                method: 'wallet',
                wallets: ['freecharge']
              },
              {
                method: 'wallet',
                wallets: ['olamoney']
              }
            ]
          },
          mostUsedMethods: {
            name: 'Most Used Methods',
            instruments: [{
                method: 'wallet',
                wallets: ['freecharge']
              },
              {
                method: 'upi'
              },
            ],
          },
          upi: {
            name: 'Pay via UPI',
            instruments: [{
              method: 'upi'
            }],
          },
          banks: {
            name: 'Pay via Card',
            instruments: [{
                method: 'upi'
              },
              {
                method: 'card'
              },
              {
                method: 'wallet'
              },
              {
                method: 'netbanking'
              },
              {
                method: 'wallet',
                wallets: ['olamoney']
              },
              {
                method: 'wallet',
                wallets: ['freecharge']
              }
            ]
          },
        },
        hide: [],
        sequence: ["block.utib", "block.walletfreecharge", "block.mostUsedMethods", "block.banks", "block.upi"],
        preferences: {
          show_default_blocks: false // Should Checkout show its default blocks?
        }
      }
    },
    "handler": function(response) {
      // alert(response.razorpay_payment_id);
      // console.log(response);

      window.location.href = '<?php echo $payment_details['success_url'] . '/' . $payment_gateway['identifier']; ?>' + '?razorpay_payment_id=' + response.razorpay_payment_id;
    },
    "modal": {
      "ondismiss": function() {
        if (confirm("Are you sure, you want to close the form?")) {
          txt = "You pressed OK!";
          console.log("Checkout form closed by the user");
        } else {
          txt = "You pressed Cancel!";
          console.log("Complete the Payment")
        }
      }
    }
  };
  var rzp1 = new Razorpay(options);
  document.getElementById('rzp-button1').onclick = function(e) {
    rzp1.open();
    e.preventDefault();
  }
</script>