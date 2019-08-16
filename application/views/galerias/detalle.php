<?php /*
    <div id="main_part_inner">
        <div id="main_part_inner_in">
            <h1><?=$nombre?></h1>
        </div>
    </div>
    <div id="socialesTop">
            <div class="fb-share-button" data-href="<?=$urlshare?>" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=$urlshare?>&amp;src=sdkpreparse">Compartir</a></div>
            <a class="twitter-share-button" href="https://twitter.com/intent/tweet">Tweet</a>
    </div>
    <div id="content_inner"></div>
    <hr class="cleanit">
    <footer id="footer"></footer>
    <script type="text/babel" src="<?= base_url();?>public/js/mainMenu.js"></script>
    <script type="text/babel" src="<?= base_url();?>public/js/ourwork.js"></script>
    <script type="text/babel" src="<?= base_url();?>public/js/mainFooter.js"></script>
    <script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
    <script type="text/babel">
    var galeriasArray = [<?=$jsonGaleria;?>];
class Modal extends React.Component {
  constructor(props) {
    super(props);
  }

  closeModal(){
   //document.getElementById("modalBg").style.display = 'none';
   ReactDOM.render(React.createElement("section", {},''), document.getElementById('galeriaFt'))
  }

  render() {
    return (
      React.createElement("section", {className:'modalBg',id:'modalBg'},
        React.createElement("div", {className:'modal'},
          React.createElement("div", {className:'modalOff',onClick:this.closeModal},'X'),
          React.createElement("img", {id:'photoModal',src:this.props.link})
        )
      )
    )
  }
}
class CarrouselItem extends React.Component {
  constructor(props) {
    super(props)
    this.handleClick = this._handleClick.bind(this, props.gal,props.foto);
  }

  propTypes: {
    id: React.PropTypes.string.isRequired,
    gal: React.PropTypes.string.isRequired,
    foto: React.PropTypes.string.isRequired,
    title: React.PropTypes.string.isRequired
  }

  componentWillReceiveProps(nextProps) {
    this.handleClick = this._handleClick.bind(this, nextProps.gal,nextProps.foto);
  }
  // esta función nos sirve de base para crear nuestro `this.handleClick`
  _handleClick(gal, foto, event) {
    //alert(`hola ${gal} /  ${foto}`);
    let url = "<?=base_url()?>public/uploads/galerias/"+gal+"/"+foto;
    ReactDOM.render(<Modal link={url} />, document.getElementById('galeriaFt'))
    event.preventDefault();
    return false;
  }

  render() {
    return (
        React.createElement("div", {className:"fourths_portfolio", onClick:this.handleClick},
          React.createElement("h4", {}, this.props.title,
            React.createElement("br", {}),
            React.createElement("span", {},"Ver Foto")
          ),
          React.createElement("a", {href:"#"},
            React.createElement("img", {src:"<?=base_url()?>public/uploads/galerias/"+this.props.gal+"/"+this.props.foto,alt:this.props.title})
          )
        )
    )
  }
}
    class Paginador extends React.Component {
      render() {
        return (<ul className="pagination"><?=$paginador;?></ul>)
      }
    }
var contactItemElements = galeriasArray
  .filter(function(contact) { return contact.foto })
  .map(function(contact) { return React.createElement(CarrouselItem, contact) });
var rootElement = React.createElement('div', {}, contactItemElements);
ReactDOM.render(rootElement, document.getElementById('galeriaBd'));
ReactDOM.render(<Paginador />, document.getElementById('pagination'));
</script>
*/
$arrayName = array('items' => $jsonGaleria, 'pagination' => $paginador, 'nombre' => $nombre);
echo json_encode($arrayName, true);
?>