var ReactCSSTransitionGroup = React.addons.CSSTransitionGroup;

var CellLink = React.createClass({displayName: "CellLink",
    render: function(){
        return(
                React.createElement("a", {href: this.props.href, target: "_blank"}, this.props.text)
        );
    }
});

var AjaxGrid = React.createClass({displayName: "AjaxGrid",
	loadDataFromServer: function() {
    jQuery.ajax({
	  type: 'POST',
	  data: {memberId: this.props.memberId},
      url: this.props.url,
      dataType: 'json',
      success: function(data) {
        this.setState({
			headers: data.headers,
			data: data.rows,
			dataLoading: false
		});
		if(this.props.afterDataLoad){
			this.props.afterDataLoad(data);
		}		
      }.bind(this),
      error: function(xhr, status, err) {
        console.error(this.props.url, status, err.toString());
      }.bind(this)
    });
  },
  getInitialState: function() {
    return {
		headers: [],
		rows: [],
		dataLoading: true,
	};
  },
  componentDidMount: function() {
    this.loadDataFromServer();    
  },
  render: function() {
	if(this.state.dataLoading)
	{
		return (
			React.createElement("div", null, 
			  React.createElement("span", null, React.createElement("img", {src: "/images/spinner.gif"}))
			)
		);		
	}
	else{
		var headers = this.state.headers.map(function(header){
			return(React.createElement("th", null, header));
		});
        var rows = '';
        if(this.state.data && this.state.data.length > 0)
        {
            rows = this.state.data.map(function(data){
                var row = data.map(function(cell){
                    if(cell && cell.type == 'link'){
                        return(React.createElement("td", null, React.createElement(CellLink, {href: cell.href, text: cell.text})));
                    }
                    return(React.createElement("td", null, cell));
                });
                return(React.createElement("tr", null, row));
            });
        }
		
		
		return (
            React.createElement(ReactCSSTransitionGroup, {transitionName: "fade", transitionAppear: true}, 
                React.createElement("table", {key: this.props.id, className: "table table-striped table-bordered"}, 
                    React.createElement("thead", null, 
                        React.createElement("tr", null, 
                            headers
                        )
                    ), 
                    React.createElement("tbody", null, 
                        rows
                    )
                )
            )
		)
	}
  }
});


