function recupDonneephp() {
    fetch('../php/app/recupDonnees.php')
        .then(response => {
            if (!response.ok) {
                throw new Error("Problème lors de la récupération des données");
            }
            return response.json();
        })
        .then(data => {
            console.log("Données récupérées :", data);
            AffichageGraph1(data.graphique1);  // Âge
            AffichageGraph2(data.graphique2);  // Sexe
            AffichageGraph3(data.graphique3);  // Lieu de vie
            AffichageGraph4(data.graphique4, data.graphiqueRegion);  // Région
            AffichageGraph5(data.graphique5);  // Zone urbaine/rurale
            AffichageGraph6(data.graphiqueLieuSoutien);  // Soutien
        })
        .catch(error => console.error("Erreur :", error));
}

function AffichageGraph1(data) {
    const width = 500, height = 400;
    const margin = { top: 20, right: 20, bottom: 50, left: 40 };
    const innerWidth = width - margin.left - margin.right;
    const innerHeight = height - margin.top - margin.bottom;

    const svg = d3.select("#graphique1").append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", `translate(${margin.left},${margin.top})`);

    const ageGroups = d3.group(data, d => {
        const age = parseInt(d.reponse);
        const start = Math.floor((age - 18) / 10) * 10 + 18;
        const end = start + 9;
        return `${start}-${end}`;
    });

    const totalCount = d3.sum(Array.from(ageGroups.values()), group => group.length);

    const ageGroupData = Array.from(ageGroups, ([key, values]) => ({
        reponse: key,
        count: values.length,
        percentage: (values.length / totalCount) * 100
    }));

    const xScale = d3.scaleBand()
        .domain(ageGroupData.map(d => d.reponse))
        .range([0, innerWidth])
        .padding(0.2);

    const yScale = d3.scaleLinear()
        .domain([0, d3.max(ageGroupData, d => d.percentage)])
        .range([innerHeight, 0]);

    svg.selectAll(".bar")
        .data(ageGroupData)
        .enter()
        .append("rect")
        .attr("class", "bar")
        .attr("x", d => xScale(d.reponse))
        .attr("y", d => yScale(d.percentage))
        .attr("width", xScale.bandwidth())
        .attr("height", d => innerHeight - yScale(d.percentage))
        .style("fill", "var(--secondary)");

    svg.selectAll(".bar-text")
        .data(ageGroupData)
        .enter()
        .append("text")
        .attr("class", "bar-text")
        .attr("x", d => xScale(d.reponse) + xScale.bandwidth() / 2)
        .attr("y", d => yScale(d.percentage) - 5)
        .attr("text-anchor", "middle")
        .style("fill", "var(--secondary)")
        .style("font-size", "12px")
        .text(d => d.percentage.toFixed(2) + "%");

    svg.append("g")
        .attr("transform", `translate(0,${innerHeight})`)
        .call(d3.axisBottom(xScale))
        .selectAll("text")
        .style("text-anchor", "middle")
        .style("fill", "var(--secondary)")
        .style("font-size", "12px");

    d3.select("#graphique1").append("div")
        .attr("class", "graph-title")
}



function AffichageGraph2(data) {
    const width = 500, height = 400, radius = Math.min(width, height) / 2;

    const svg = d3.select("#graphique2").append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", `translate(${width / 2},${height / 2})`);

    const pie = d3.pie()
        .value(d => parseInt(d.count));

    const arc = d3.arc()
        .innerRadius(0)
        .outerRadius(radius);

    const color = d3.scaleOrdinal(d3.schemeCategory10);

    const pieData = pie(data);

    svg.selectAll("path")
        .data(pieData)
        .enter()
        .append("path")
        .attr("d", arc)
        .attr("fill", d => color(d.data.reponse))
        .attr("stroke", "white")
        .style("stroke-width", "2px");

    svg.selectAll("text")
        .data(pieData)
        .enter()
        .append("text")
        .attr("transform", d => `translate(${arc.centroid(d)})`)
        .style("text-anchor", "middle")
        .style("font-size", "12px")
        .text(d => d.data.reponse + " : " + d.data.count);

    d3.select("#graphique2").append("div")
        .attr("class", "graph-title")
}

function AffichageGraph3(data) {
    const width = 500, height = 400;
    const margin = { top: 20, right: 20, bottom: 50, left: 40 };
    const innerWidth = width - margin.left - margin.right;
    const innerHeight = height - margin.top - margin.bottom;

    const svg = d3.select("#graphique3").append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", `translate(${margin.left},${margin.top})`);

    const xScale = d3.scaleBand()
        .domain(data.map(d => d.reponse))
        .range([0, innerWidth])
        .padding(0.2);

    const yScale = d3.scaleLinear()
        .domain([0, d3.max(data, d => parseInt(d.count))])
        .range([innerHeight, 0]);

    const bars = svg.selectAll(".bar")
        .data(data)
        .enter()
        .append("rect")
        .attr("class", "bar")
        .attr("x", d => xScale(d.reponse))
        .attr("y", d => yScale(parseInt(d.count)))
        .attr("width", xScale.bandwidth())
        .attr("height", d => innerHeight - yScale(parseInt(d.count)))
        .style("fill", "var(--secondary)");

    svg.selectAll(".bar-text")
        .data(data)
        .enter()
        .append("text")
        .attr("class", "bar-text")
        .attr("x", d => xScale(d.reponse) + xScale.bandwidth() / 2)
        .attr("y", d => innerHeight + 15)
        .attr("text-anchor", "middle")
        .style("opacity", 0)
        .style("fill", "var(--secondary)")
        .style("font-size", "12px")
        .text(d => d.reponse);

    bars.on("mouseover", function(event, d) {
        d3.select(this).style("fill", "#ff0000");

        svg.selectAll(".bar-text")
            .filter((data) => data.reponse === d.reponse)
            .style("opacity", 1);
    })
        .on("mouseout", function(event, d) {
            d3.select(this).style("fill", "var(--secondary)");

            svg.selectAll(".bar-text")
                .filter((data) => data.reponse === d.reponse)
                .style("opacity", 0);
        });

    svg.append("g")
        .call(d3.axisLeft(yScale))
        .selectAll("text")
        .style("text-anchor", "middle")
        .style("fill", "var(--secondary)")
        .style("font-size", "12px");

    d3.select("#graphique3").append("div")
        .attr("class", "graph-title");
}



function AffichageGraph4(data, region) {
    const width = 500, height = 400;
    const margin = { top: 20, right: 20, bottom: 50, left: 60 };
    const innerWidth = width - margin.left - margin.right;
    const innerHeight = height - margin.top - margin.bottom;
    const svg = d3.select("#graphique4").append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", `translate(${margin.left},${margin.top})`);

    const xScale = d3.scaleBand()
        .domain(region.map(d => d.reponse))
        .range([0, innerWidth])
        .padding(0.2);

    const yScale = d3.scaleLinear()
        .domain([0, d3.max(data, d => parseInt(d.count))])
        .range([innerHeight, 0]);

    const bars = svg.selectAll(".bar")
        .data(data)
        .enter()
        .append("rect")
        .attr("class", "bar")
        .on("mouseover", function(event, d) {
            d3.select(this).style("fill", "#ff0000");
            // afficher la region
            const index = data.indexOf(d);
            svg.selectAll(".region-text")
                .filter((_, i) => i === index)
                .style("opacity", 1);
        })
        .on("mouseout", function(event, d) {
            d3.select(this).style("fill", "var(--secondary)");
            // masquer la region
            const index = data.indexOf(d); //index de l'élément
            svg.selectAll(".region-text")
                .filter((_, i) => i === index)
                .style("opacity", 0);
        })
        .attr("x", d => xScale(d.reponse))
        .attr("y", d => yScale(parseInt(d.count)))
        .attr("width", xScale.bandwidth())
        .attr("height", d => innerHeight - yScale(parseInt(d.count)))
        .style("fill", "var(--secondary)");

    // nom des regions sous les barres
    svg.selectAll(".region-text")
        .data(data)
        .enter()
        .append("text")
        .attr("class", "region-text")
        .attr("x", d => xScale(d.reponse) + xScale.bandwidth() / 2)
        .attr("y", d => innerHeight + 15)
        .attr("text-anchor", "middle")
        .style("opacity", 0)
        .style("fill", "var(--secondary)")
        .style("font-size", "12px")
        .text(d => d.reponse);

    // repère axe ordonnee
    svg.append("g")
        .call(d3.axisLeft(yScale))
        .selectAll("text")
        .style("text-anchor", "middle")
        .style("fill", "var(--secondary)")
        .style("font-size", "12px");

    // trait en bas
    svg.append("g")
        .attr("class", "x-axis")
        .append("line")
        .attr("x1", 0)
        .attr("y1", innerHeight)
        .attr("x2", innerWidth)
        .attr("y2", innerHeight)
        .style("stroke", "var(--secondary)")
        .style("stroke-width", 1);

    //trait à gauche
    svg.append("g")
        .attr("class", "y-axis")
        .append("line")
        .attr("x1", 0)
        .attr("y1", 0)
        .attr("x2", 0)
        .attr("y2", innerHeight)
        .style("stroke", "var(--secondary)")
        .style("stroke-width", 1);

    d3.select("#graphique4").append("div")
        .attr("class", "graph-title")
}

