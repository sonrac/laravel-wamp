$(document).ready(function () {
  var connection = new autobahn.Connection({
    url: 'ws://127.0.0.1:9090/',
    realm: 'realm1'
  });

  connection.onopen = function (session) {

    // 4) call a remote procedure
    session.call('app.hello', [2, 3]).then(
      function (res) {
        console.log("Result:", res);
      }
    );
  };

  connection.open();
})