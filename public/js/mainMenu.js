class Menu extends React.Component {
  openMenu(){
    var nav = document.getElementById('menu').style.display;
    if(nav == 'block'){
      document.getElementById('menu').style.display = 'none';
    } else {
      document.getElementById('menu').style.display = 'block';
    }
  }
  render() {
    var menus = [
      'Index',
      'Bio',
      'Galerías',
      'Proyectos',
      'Contácto'
      ]
    var urls = [
      'home',
      'bio',
      'galerias',
      'proyectos',
      'contacto'
      ]
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

class Element extends React.Component {
  render() {
    var url='http://yorch3004.xyz/'
      + this.props.enlace
        .toLowerCase()
        .trim()
        .replace(' ', '-');
    if (window.location.href.indexOf(this.props.enlace) != -1){
      var param = {href: url,className:'active'}
    } else { 
      var param = {href: url}
    }
    return React.createElement(
        'a',
        param,
        this.props.label
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
