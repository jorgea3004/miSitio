class CarrouselItem extends React.Component {
  propTypes: {
    id: React.PropTypes.string.isRequired,
    gal: React.PropTypes.string.isRequired,
    foto: React.PropTypes.string.isRequired
  }

  render() {
    return (
        React.createElement('li', {'data-id':this.props.id,id:'data'+this.props.id},
          React.createElement('img', {src:'http://yorch3004.xyz/public/uploads/galerias/'+this.props.gal+ '/'+this.props.foto})
        )
    )
  }
}

var contactItemElements = carrusel
  .filter(function(contact) { return contact.foto })
  .map(function(contact) { return React.createElement(CarrouselItem, contact) })

var rootElement =
  React.createElement('div', {id:'main_part_in'}, 
    React.createElement('div', {className:"navega",id:'anterior'},
      React.createElement('p', {}, '<<')
    ),
    React.createElement('div', {id:"main_part_in_bg",className:"carrousel"}, 
      React.createElement('ul', { className:"bxslider"}, contactItemElements)
    ),
    React.createElement('div', {className:"navega",id:'siguiente'},
      React.createElement('p', {}, '>>')
    )
  )

ReactDOM.render(rootElement, document.getElementById('main_part'))

let j = 0;
carrusel.map(function(i,val){++j;})
let i = 1;
let k = 0;
let l = 0;
if(j>0){
  setInterval(() => {
    k=i+1;
    if (i>1) { 
      let y = document.getElementById('data'+i);
      y.style.display = 'none';
    };
    let x = document.getElementById('data'+k);
    x.style.display = 'block';
    ++i;
    if (i>=j) {
      let y = document.getElementById('data'+j);
      y.style.display = 'none';
      i=0;
    };
  }, 5000)
}