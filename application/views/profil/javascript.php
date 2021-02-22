<script src="https://d3js.org/d3.v4.js"></script>
<!-- DataTables -->
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script>

<script>
    // set the dimensions and margins of the graph
    var width = 1200
    var height = 2500

    // append the svg object to the body of the page
    var svg = d3.select("#my_dataviz")
        .append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(40,0)");  // bit of margin on the left = 40

    // read json data
    d3.json("<?=base_url('Profil/BabTreeJson')?>", function (data) {
        // Create the cluster layout:
        var cluster = d3.tree()
            .size([height, width - 100]);  // 100 is the margin I will have on the right side

        // Give the data to this cluster layout:
        var root = d3.hierarchy(data, function (d) {
            return d.children;
        });
        cluster(root);
        
        // Add the links between nodes:
        svg.selectAll('path')
            .data(root.descendants().slice(1))
            .enter()
            .append('path')
            .attr("d", function (d) {
                return "M" + d.y + "," + d.x
                    + "C" + (d.parent.y + 50) + "," + d.x
                    + " " + (d.parent.y + 150) + "," + d.parent.x // 50 and 150 are coordinates of inflexion, play with it to change links shape
                    + " " + d.parent.y + "," + d.parent.x;
            })
            .style("fill", 'none')
                .attr("stroke", function (d) {
                return d.data.color;
            })


        // Add a circle for each node.
        svg.selectAll("g")
            .data(root.descendants())
            .enter()
            .append("g")
            .attr("transform", function (d) {
                return "translate(" + d.y + "," + d.x + ")"
            })
            .append("circle")
            .attr("r", 7)
            .style("fill", "#69b3a2")
            .attr("stroke", "black")
            .style("stroke-width", 2)

        svg.selectAll("text")
            .data(root.descendants())
            .enter()
            .append("text")
            .attr("font-family", "Arial, Helvetica, sans-serif")
            .attr("fill", "Black")
            .style("font", "normal 12px Arial")
            .attr("transform", function(d) {
                return "translate(" + d.y + "," + d.x + ")"
            })   
            .attr("dy", ".35em")
            .attr("y", "15")
            .attr("text-anchor", "middle")
            .text(function(d) {
                console.log(d)
                return d.data.name;
            });
    })
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
<script>
    var data_pie = <?=$data_pie?>;
    var labels_pie = <?=$label_pie?>;
    //alert(json_labels_pie.split(','))
    var graphColors = [];
    var graphOutlines = [];
    var hoverColor = [];

    var internalDataLength = data_pie.length;
    i = 0;
    while (i <= internalDataLength) {
        var randomR = Math.floor((Math.random() * 130) + 100);
        var randomG = Math.floor((Math.random() * 130) + 100);
        var randomB = Math.floor((Math.random() * 130) + 100);
    
        var graphBackground = "rgb(" 
                + randomR + ", " 
                + randomG + ", " 
                + randomB + ")";
        graphColors.push(graphBackground);
        
        var graphOutline = "rgb(" 
                + (randomR - 80) + ", " 
                + (randomG - 80) + ", " 
                + (randomB - 80) + ")";
        graphOutlines.push(graphOutline);
        
        var hoverColors = "rgb(" 
                + (randomR + 25) + ", " 
                + (randomG + 25) + ", " 
                + (randomB + 25) + ")";
        hoverColor.push(hoverColors);
        
        i++;
    };

    var config = {
      type: 'pie',
      data: {
        datasets: [{
            data: data_pie,
            backgroundColor: graphColors,
            hoverBackgroundColor: hoverColor,
            borderColor: graphOutlines,
            label: 'Tes Terakhir'
        }],
        labels: labels_pie
      },
      options: {
        responsive: true
      }
    };

    window.onload = function() {
      var ctx = document.getElementById('pie-chart').getContext('2d');
      window.myPie = new Chart(ctx, config);
    };

</script>