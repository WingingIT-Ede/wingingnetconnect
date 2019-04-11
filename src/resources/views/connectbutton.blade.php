<style>
    #hoviusNetButton{
    background:    #674ea7;
    background:    linear-gradient(#674ea7, #9900ff);
    border-radius: 5px;
    padding:       8px 20px;
    color:         #ffffff;
    display:       inline-block;
    font:          normal bold 19px/1 "Lobster Two", cursive;
    text-align:    center;
    text-shadow:   1px 1px #000000;
    }
</style><a id="hoviusNetButton" href="https://network.wshovius.nl/oauth/authorize?response_type=code&client_id={{config('hoviusnetconnect.client_id')}}&redirect_uri={{config('hoviusnetconnect.redirect_uri')}}&scope=*">
    CONNECT WITH HOVIUSNET!
</a>