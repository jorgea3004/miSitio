class Footer extends React.Component {
  render(){
    return (
      <div id="footer_in">
        <section>
          <a href="https://www.twitter.com/jorgea3004" target="_blank"><img src="http://yorch3004.xyz/public/img/icon_twitter.png" /></a>
          <a href="https://www.facebook.com/jorgea3004" target="_blank"><img src="http://yorch3004.xyz/public/img/icon_facebook.png" /></a>
          <a href="https://www.instagram.com/jorgea3004" target="_blank"><img src="http://yorch3004.xyz/public/img/icon_instagram.png" /></a>
        </section>
        <span>
          Contácto&nbsp;
          <a href='mailto:jorgea3004@gmail.com'>
            GMail
          </a>
        </span>
      </div>
      )
  }
}

ReactDOM.render(
  <Footer />,
  document.getElementById('footer')
);
