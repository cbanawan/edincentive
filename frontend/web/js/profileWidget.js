var RadioList = React.createClass({displayName: "RadioList",
	render: function(){
        var responses = [];
        var responseValue = this.props.responseValue;
        
        if(this.props.responses.length > 10){
            var bucket = [];
            var divisor = Math.ceil(this.props.responses.length / 3);
            for(var i=0; i<this.props.responses.length; i++){
                var response = this.props.responses[i];
                if(!(i%divisor) && i>0)
                {
                    responses.push(bucket);
                    bucket = [];                    
                }
                
                bucket.push(
                    React.createElement("div", {className: "radio"}, 
						React.createElement("label", null, 
							React.createElement("input", {type: "radio", key: 'memberData_'+response.questionId+'_'+response.questionResponseId, name: "memberData["+response.questionId+"]", defaultChecked: responseValue == response.questionResponseId, value: response.questionResponseId}, response.questionResponseText)
						)
					)        
                );
            }
            responses.push(bucket);
            
            responses = responses.map(function(response){
                return ( 
                React.createElement("div", {className: "col-md-4"}, 
                    response
                )
                );
            });
        }
        else{            
            responses = this.props.responses.map(function(response){
			return (
					React.createElement("div", {className: "radio"}, 
						React.createElement("label", null, 
							React.createElement("input", {type: "radio", key: "memberData_"+response.questionId+"_"+response.questionResponseId, name: "memberData["+response.questionId+"]", defaultChecked: responseValue == response.questionResponseId, value: response.questionResponseId}, response.questionResponseText)
						)
					));
            });            
        }
		
        
		return (
            React.createElement("div", {key: "memberData_"+this.props.questionId, className: "row-fluid"}, 		
                responses
            )
		);		
	}
});

var CheckboxList = React.createClass({displayName: "CheckboxList",
    handleExclusiveResponse: function(e){
        var value = e.target.value;
        if(e.target.checked){
            for(var ref in this.refs){
                if(this.refs.hasOwnProperty(ref)){
                    var checkbox = React.findDOMNode(this.refs[ref]);
                    if(e.target.value != checkbox.value){
                        checkbox.checked = false;
                        checkbox.disabled = true;
                    }                    
                }
            }
        }
        else{
            for(var ref in this.refs){
                if(this.refs.hasOwnProperty(ref)){
                    var checkbox = React.findDOMNode(this.refs[ref]);
                    checkbox.disabled = false;                                        
                }
            }            
        }        
    },
    componentDidMount: function(){
        var response = {};
        var responseValue = this.props.responseValue;
        
        if(this.props.responseValue){
            for(var i=0; i<this.props.responses.length; i++){
                response = this.props.responses[i];
                if(responseValue.indexOf(response.questionResponseId) !== -1){
                    if(response.questionResponseControl.questionResponseControlExclusive){
                        for(var ref in this.refs){
                            if(this.refs.hasOwnProperty(ref)){
                                var checkbox = React.findDOMNode(this.refs[ref]);
                                if(response.questionResponseId != checkbox.value){
                                    checkbox.checked = false;
                                    checkbox.disabled = true;
                                }                    
                            }
                        }
                        break;
                    }
                }                    
            }
        }
        
    },
	render: function(){
        var responses = [];
        var responseValue = this.props.responseValue;
        
        if(this.props.responses.length > 10){            
            var bucket = [];
            var divisor = Math.ceil(this.props.responses.length / 3);
            for(var i=0; i<this.props.responses.length; i++){
                var response = this.props.responses[i];
                if(!(i%divisor) && i>0)
                {
                    responses.push(bucket);
                    bucket = [];                    
                }
                var inputId = 'memberData_'+response.questionId+'_'+response.questionResponseId;
                bucket.push(
                    React.createElement("div", {className: "checkbox", key: inputId+'_input_container'}, 
						React.createElement("label", {key: inputId+'_input_label'}, 
							React.createElement("input", {type: "checkbox", ref: inputId, key: inputId, name: "memberData["+response.questionId+"][]", defaultChecked: responseValue && responseValue.indexOf(response.questionResponseId) !== -1, value: response.questionResponseId, onChange: (response.questionResponseControl.questionResponseControlExclusive)?this.handleExclusiveResponse:function(){}}, response.questionResponseText)
						)
					)        
                );
            }
            responses.push(bucket);
            
            responses = responses.map(function(response,index){
                return ( 
                React.createElement("div", {className: "col-md-4", key: "memberData_group_"+index}, 
                    response
                )
                );
            });
        }
        else{
            for(var i=0; i<this.props.responses.length; i++){
                var response = this.props.responses[i];
                var inputId = 'memberData_'+response.questionId+'_'+response.questionResponseId;
                responses.push(
                   React.createElement("div", {className: "checkbox", key: inputId+'_input_container'}, 
						React.createElement("label", {key: inputId+'_input_label'}, 
							React.createElement("input", {type: "checkbox", ref: inputId, key: inputId, name: "memberData["+response.questionId+"][]", defaultChecked: responseValue && responseValue.indexOf(response.questionResponseId) !== -1, value: response.questionResponseId, onChange: (response.questionResponseControl.questionResponseControlExclusive)?this.handleExclusiveResponse:function(){}}, response.questionResponseText)
						)
					)     
                );
            }            
        }		
        
		return (
            React.createElement("div", {key: "memberData_"+this.props.questionId, className: "row-fluid"}, 		
                responses
            )
		);		
	}
});

var ShortText = React.createClass({displayName: "ShortText",
    render: function(){
        return(
                React.createElement("input", {type: "text", key: 'memberData_'+this.props.questionId, className: "form-control", name: 'memberData['+this.props.questionId+']', defaultValue: this.props.value})
        );
    }
});

var LongText = React.createClass({displayName: "LongText",
    render: function(){
        return(
            React.createElement("textarea", {key: 'memberData_'+this.props.questionId, className: "form-control", name: 'memberData['+this.props.questionId+']', defaultValue: this.props.value})
        );
    }
});

var DropList = React.createClass({displayName: "DropList",
    render: function(){
        responses = this.props.responses.map(function(response){
            var inputId = 'memberData_'+response.questionId+'_'+response.questionResponseId;
			return (
                React.createElement("option", {key: inputId, value: response.questionResponseId}, 
                    response.questionResponseText
                )
            );
        });
        
        return(
            React.createElement("select", {key: 'memberData_'+this.props.questionId, className: "form-control", name: 'memberData['+this.props.questionId+']', defaultValue: this.props.value}, 
                React.createElement("option", {key: 'memberData_'+this.props.questionId+'_empty', value: ""}), 
                responses
            )
        );
    }
});

var ProfileSurvey = React.createClass({displayName: "ProfileSurvey",
    getInitialState: function() {
        return {
            surveyData: {
                progress: false,
                memberData: [],
                question: [
                    {
                        "questionId": "",
                        "questionTypeId": "0",
                        "questionText": ''
                    }
                ]
            }            
        };
    },
    handleInit: function(){
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        this.setState({ajaxLoading: true, ajaxLoadingMessage: 'Loading survey...'});
        jQuery.ajax({
            type: 'POST',
            url: this.props.nextBtnUrl,
            data: {profileId: this.props.profileId, _csrf: csrfToken},
            dataType: 'json',
            success: function(data) {
                this.setState({surveyData: data, ajaxLoading: false});
            }.bind(this),
            error: function(xhr, status, err){
                console.error(this.props.nextBtnUrl, status, err.toString());
            }.bind(this)
        });
    },
    handleSubmit: function(e){
         e.preventDefault();
         return;
    },
    handleNextButtonPress: function(e) {
        e.preventDefault();
        
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var memberData = jQuery('#profile-form').serialize();
        //var ajaxLoading = 
        
        if(memberData && memberData != '')
        {
            var postData = {
                'profileId': this.props.profileId, 
                '_csrf': csrfToken            
            };
            postData = jQuery.param(postData);
           
            this.setState({ajaxLoading: true, ajaxLoadingMessage: 'Loading next question...'});
            
            jQuery.ajax({
                type: 'POST',
                url: this.props.nextBtnUrl,
                data: postData+'&'+memberData,
                dataType: 'json',
                success: function(data) {
                    this.setState({surveyData: data, ajaxLoading: false});
                }.bind(this),
                error: function(xhr, status, err){
                    console.error(this.props.url, status, err.toString());
                }.bind(this)
            });            
        }
        else
        {
            var currentState = this.state.surveyData;
            currentState.errors = 'Answer cannot be blank.'
            this.setState({surveyData: currentState});
        }        
    },
    handlePreviousButtonPress: function(e) {
        e.preventDefault();
        
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
               
        var postData = {
                'profileId': this.props.profileId, 
                '_csrf': csrfToken            
            };
        postData = jQuery.param(postData);
        this.setState({ajaxLoading: true, ajaxLoadingMessage: 'Loading previous question...'});
        jQuery.ajax({
            type: 'POST',
            url: this.props.previousBtnUrl,
            data: postData,
            dataType: 'json',
            success: function(data) {
                this.setState({surveyData: data, ajaxLoading: false});
            }.bind(this),
            error: function(xhr, status, err){
                console.error(this.props.previousBtnUrl, status, err.toString());
            }.bind(this)
        });            
    },
    handleStartButtonPress: function(e){
        e.preventDefault();
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
               
        var postData = {
                'profileId': this.props.profileId, 
                '_csrf': csrfToken            
            };
        postData = jQuery.param(postData);
        this.setState({ajaxLoading: true, ajaxLoadingMessage: 'Loading previous question...'});
        jQuery.ajax({
            type: 'POST',
            url: this.props.startBtnUrl,
            data: postData,
            dataType: 'json',
            success: function(data) {
                this.setState({surveyData: data, ajaxLoading: false});
            }.bind(this),
            error: function(xhr, status, err){
                console.error(this.props.previousBtnUrl, status, err.toString());
            }.bind(this)
        });
    },
    handleNextProfileButtonPress: function(e){
        e.preventDefault();
        window.location = this.props.nextProfileUrl+this.state.surveyData.nextProfile;
    },
    componentDidMount: function(){
        if(!this.state.surveyData.sId){
            this.handleInit();
        }
    },
    componentDidUpdate: function(){
        jQuery('.active .profile-nav .bar').attr('style', 'width: ' + this.state.surveyData.progress + '%');
        jQuery("html, body").animate({
                    scrollTop: $("#profile-widget").offset().top - 150
                }, 300);
    },
    renderQuestion: function(question){
        var memberData = this.state.surveyData.memberData;
        var inputId = 'memberData'+question.questionId;
        switch(question.questionTypeId){
            case "1":
                return(
                    React.createElement("div", {key: inputId+'_container', className: "questionContainer", className: "form-group"}, 
                        React.createElement("p", {key: inputId+'_text'}, question.questionText), 
                        React.createElement(RadioList, {key: inputId, responses: question.questionResponse, questionId: question.questionId, responseValue: memberData[question.questionId]})
                    )
                );
                break;
            case "2":
                return(
                    React.createElement("div", {key: inputId+'_container', className: "questionContainer", className: "form-group"}, 
                        React.createElement("p", {key: inputId+'_text'}, question.questionText), 
                        React.createElement(CheckboxList, {key: inputId, responses: question.questionResponse, questionId: question.questionId, responseValue: memberData[question.questionId]})
                    )
                );
                break;
            case "3":
                return(
                   React.createElement("div", {key: inputId+'_container', className: "questionContainer", className: "form-group"}, 
                        React.createElement("p", {key: inputId+'_text'}, question.questionText), 
                        React.createElement(ShortText, {key: inputId, questionId: question.questionId, value: memberData[question.questionId]})
                   )     
                );
            case "4":
                return(
                   React.createElement("div", {key: inputId+'_container', className: "questionContainer", className: "form-group"}, 
                        React.createElement("p", {key: inputId+'_text', dangerouslySetInnerHTML: {__html:question.questionText}}), 
                        React.createElement(LongText, {key: inputId, questionId: question.questionId, value: memberData[question.questionId]})
                   )     
                );
            case "5":
                return(
                   React.createElement("div", {key: inputId+'_container', className: "questionContainer", className: "form-group"}, 
                        React.createElement("p", {key: inputId+'_text'}, question.questionText), 
                        React.createElement(DropList, {key: inputId, responses: question.questionResponse, questionId: question.questionId, value: memberData[question.questionId]})
                   )     
                );
            default:
                return(
                    React.createElement("div", {key: "textUpdateContainer", className: "questionContainer", className: "form-group"}, 
                        React.createElement("p", {key: "textUpdateText"}, question.questionText)
                    )
                );
                break;
        }
    },
    render: function() {
        var questions = [];
        if(this.state.surveyData.question.length > 4)
        {
            var bucket = [];
            var divisor = Math.ceil(this.state.surveyData.question.length / 2);
            for(var i=0; i<this.state.surveyData.question.length; i++){
                var q = this.state.surveyData.question[i];
                if(!(i%divisor) && i>0)
                {
                    questions.push(bucket);
                    bucket = [];                    
                }
                
                bucket.push(
                    this.renderQuestion(q)
                );
            }
            questions.push(bucket);
            
            questions = questions.map(function(question, index){
                return ( 
                React.createElement("div", {key: "questiongroup_"+index, className: "col-md-6"}, 
                    question
                )
                );
            });
        }
        else{
            for(var i=0; i<this.state.surveyData.question.length; i++){
                var q = this.state.surveyData.question[i];
                questions.push(
                    this.renderQuestion(q)
                );
            }            
        }        
        
        return (
                React.createElement("div", {style: {position:'relative', opacity:(this.state.ajaxLoading)?'0.5':'1'}}, 
                    React.createElement("h2", null, this.state.surveyData.profileName), 
                    React.createElement("div", {className: "progress", style: {display:(this.state.surveyData.progress)?'':'none'}}, 
                        React.createElement("div", {className: "bar progress-bar progress-bar-primary", style: {width: this.state.surveyData.progress+'%'}})
                    ), 
                    React.createElement("div", {key: 'question_error', className: "alert-danger alert", style: {display:(this.state.surveyData.errors)?'':'none'}}, 
                        this.state.surveyData.errors
                    ), 
            
                    React.createElement("form", {ref: "profileForm", key: "profile-form", id: "profile-form", onSubmit: this.handleSubmit}, 
                        questions, 
                        React.createElement("p", {key: "profile-overlay", className: "text-primary", style: {position:'absolute', left:'0px', top:'-10px', width:'100%', height:'100%', 'text-align':'center', display:(this.state.ajaxLoading)?'':'none'}}, this.state.ajaxLoadingMessage), 
                        React.createElement("div", {key: "profile_end_page", style: {display:(this.state.surveyData.progress == '100')?'':'none'}}, 
                            React.createElement("center", null, 
                                React.createElement("h3", null, "You've completed the profile!"), 
                                React.createElement("p", {className: "alert-default alert", style: {width: "48%"}}, 
                                    "Profiles questions help find surveys relevant to you.", React.createElement("br", null), React.createElement("br", null), "Yes we understand that it is long and tiring to fill them out.  If you grow restless, come back another day to finish."
                                )
                            )
                        ), 
                        React.createElement("div", {className: "clearfix"}), 
                        React.createElement("div", {className: "pager survey-buttons", style: {position:'relative'}}, 
                            React.createElement("div", {ref: "ajaxLoading", style: {position:'absolute', left:'50%', display:(this.state.ajaxLoading)?'':'none'}}, 
                                React.createElement("img", {src: "/images/spinner.gif", style: {position:'relative', left: '-50%'}})
                            ), 
                            React.createElement("input", {type: "submit", disabled: this.state.ajaxLoading || this.state.surveyData.progress == '1', ref: "previousBtn", value: "Previous", className: "previous btn btn-lg btn-primary pull-left", style: {width: '48%', display:(this.state.surveyData.progress == '100')?'none':''}, onClick: this.handlePreviousButtonPress}), 
                            React.createElement("input", {type: "submit", disabled: this.state.ajaxLoading || this.state.surveyData.progress == '100', ref: "nextBtn", value: "Next", className: "next btn btn-lg btn-primary pull-right", style: {width: '48%', display:(this.state.surveyData.progress == '100')?'none':''}, onClick: this.handleNextButtonPress}), 
                            React.createElement("div", {className: "clearfix"}), 
                            React.createElement("br", null), 
                            React.createElement("input", {type: "submit", disabled: this.state.ajaxLoading, ref: "startBtn", value: "Start Over", className: "start-over btn btn-lg btn-primary pull-left", style: {width: '48%', display:(this.state.surveyData.progress == '100')?'':'none'}, onClick: this.handleStartButtonPress}), 
                            React.createElement("input", {type: "submit", disabled: this.state.ajaxLoading, ref: "nextProfile", value: "Next Profile", className: "next-profile btn btn-lg btn-primary pull-right", style: {width: '48%', display:(this.state.surveyData.progress == '100' && this.state.surveyData.nextProfile)?'':'none'}, onClick: this.handleNextProfileButtonPress})
                        )
                    )
                )
        );
    }
});
