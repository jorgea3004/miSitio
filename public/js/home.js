class Home extends React.Component {
  render(){
    return (
        React.createElement('section', {},
	        React.createElement('p', {}, 'En Construcción'),
            React.createElement("br", {}),
	        React.createElement('img', {src:'http://yorch3004.xyz/public/img/construccion.gif'})
        )
    )
  }
}
ReactDOM.render(
  <Home />,
  document.getElementById('contentm')
);