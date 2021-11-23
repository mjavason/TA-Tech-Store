    let movies = [];
    //example: {id:159223019, title, 'Deadpool', year:2015}

    const addMovie = (ev)=> {
        ev.preventDefault();//Stops the form from doing its default action of refreshing the page

        let movie = {
            id: Date.now(),
            title: document.getElementById('title').value,
            year: document.getElementById('yr').value
        }

        movies.push(movie);
        document.forms[0].reset;//Clears the form so it can accept more data

//For display purposes only
        console.warn('added', {movies});
        let pre = document.querySelector('#msg pre');

        pre.textContent = '/n' + JSON.stringify(movies, 't', 2);

        //saving to local storage
    }

    document.addEventListener('DOMContentLoaded', ()=>{
        document.getElementById('btn').addEventListener('click', addMovie);
    })
