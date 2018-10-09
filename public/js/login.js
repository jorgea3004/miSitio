class Login extends React.Component {
  render() {
    var a = 0;
    return React.createElement('div',{id:'header_in',name:'header_in'},
      React.createElement('h2',{},
        React.createElement('a',{href:'http://yorch3004.xyz/'},
          React.createElement('b',{},'i'),
            'YORCH'
          )
        ),
        React.createElement('div',{className:'menumob', onClick:this.openMenu},''),
        React.createElement('nav',{id:'menu'},
          React.createElement('ul',
            null,
            menus.map(function(v,i){
              return React.createElement('li',
                {key: i},
                React.createElement(Element, {label: v, enlace: urls[i]})
              )
            })
          )
        )
      )
  }
}

ReactDOM.render(
  React.createElement(
    Menu,
    null
  ),
  document.getElementById('header')
);
