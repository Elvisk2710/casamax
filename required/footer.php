<footer class="footer">
  <div class="left-footer">
    <div class="footer-title">
      <div class="logo-img">
        <img class="logo" src="../images/logoorange.png" alt="logo">
      </div>
      <div class="logo-title">
        <h4>
          CasaMax
        </h4>
      </div>
    </div>
    <div class="footer-contact-details">
      <div class="contact">
        <a target="_blank" href="mailto:info@casamax.co.zw?subject=Feedback to Casamax.co.zw">
          <img src="../images/mail.png" alt="">
          <p>info@casamax.co.zw</p>
        </a>
      </div>
      <div class="contact">
        <a target="_blank" href="https://www.facebook.com/profile.php?id=100093414304668">
          <img src="../images/facebook.png" alt="">
          <p>facebook</p>
        </a>
      </div>
      <div class="contact">
        <a target="_blank" href="https://www.instagram.com/casamax.co.zw/">
          <img src="../images/instagram.png" alt="">
          <p>casamax.co.zw</p>
        </a>
      </div>
      <div class="contact">
        <a target="_blank" href="https://wa.me/+263786989144">
          <img src="../images/whatsapp.png" alt="">
          <p>whatsApp</p>
        </a>
      </div>

    </div>
  </div>
  <div class="right-footer">
    <div class="footer-p">
      <h3 class="abt">
        <a href="aboutus.php">About</a> CasaMax
      </h3>
      <p>
        Our platform connects landlords and students, streamlining the process of finding the perfect match. With our efficient matching system, we ensure that both parties connect seamlessly, saving time and effort for everyone involved.
      </p>

    </div>
    <div class="bottom-footer">
      <div class="quick-action">
        <h2>
          Our Services
        </h2>
        <div class="contact">
          <a target="_blank" href="https://wa.me/+263786989144">
            <p>Advertise</p>
          </a>
        </div>
        <div class="contact">
          <a target="_blank" href="https://wa.me/+263786989144">
            <p>Manage Rental</p>
          </a>
        </div>
        <div class="contact">
          <a target="_blank" href="https://wa.me/+263786989144">
            <p>Help</p>
          </a>
        </div>
        <div class="contact">
          <a target="_blank" href="https://wa.me/+263786989144">
            <p>Login</p>
          </a>
        </div>
        <div class="contact">
          <a target="_blank" href="https://wa.me/+263786989144">
            <p>Choose University</p>
          </a>
        </div>
      </div>
      <p class="abt">
        <a href="../privacy_policy.html">Our Privacy Policy </a>
        <br>
        <a href="../disclaimer.html">Disclaimer</a>
      </p>
    </div>
  </div>
</footer>

<style>

/* --footer-- */

footer {
  padding: 2rem 6rem;
  display: flex;
  justify-content: space-around;
  align-items: center;
  flex-direction: row;
  background-color: white;
  margin: 2rem 2rem;
  border-radius: 20px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.left-footer, .right-footer{
  flex-basis: 50%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: start;
  padding: 0 4rem;
}
.footer-title{
  display: flex;
  flex-direction: row;
  justify-content: start;
  align-items: center;
  gap: 1rem;
}
.left-footer .logo-title h4{
  font-size: 1.5rem;
  color: rgb(8, 8, 12);
  font-weight: 700;
}
.footer-contact-details{
  display: flex;
  justify-content: start;
  align-items: center;
  flex-direction: column;
}
.contact{
  display: flex;
  flex-direction: row;
  justify-content: start;
  align-items: center;
  gap: 1rem;
  width: 100%;
  padding: 0 2rem;
}
.contact a{
  text-decoration: none;
  width: 100%;
  display: flex;
  flex-direction: row;
  justify-content: start;
  align-items: center;
  width: 100%;
  gap: 1rem;
}
.contact a img{
  width: 1.2rem;
  height: 1.2rem;
}
.contact a p{
  width: 100%;
  text-align: left;
  color: rgb(8, 8, 12);
}
.footer p {
  color: rgb(8, 8, 12, 0.6);
  margin: 0.8rem 0;
  font-size: 1rem;
}
.bottom-footer{
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  width: 100%;
}
.abt a {
  text-decoration: underline;
  color: rgb(252, 153, 82);
  cursor: pointer;
}


</style>
<script>
  var navBar = document.getElementById("navBar");

  function togglebtn() {

    navBar.classList.toggle("hidemenu")
  }
</script>
<script>
  var dropdown = document.getElementById("dropdown");

  function togglebtn1() {

    navBar.classList.toggle("hideuni")
  }
</script>