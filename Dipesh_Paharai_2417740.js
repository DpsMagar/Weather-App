let weather = {
  apiKey: 'cfeaf659bcb84af645946366b3b2938a',
  fetchWeather: function (city) {
    fetch(`fetch_weather.php?city=${city}`)
      .then((response) => {
        if (!response.ok) {
          alert('No weather found.')
          throw new Error('No weather found.')
        }
        return response.json()
      })
      .then((data) => this.displayWeather(data))
  },
  displayWeather: function (data) {
    const { name } = data;
    const { icon, description } = data.weather[0];
    const { temp, humidity } = data.main;
    const { speed } = data.wind;

    document.querySelector('.city').innerText = 'Weather inn ' + name
    document.querySelector('.icon').src =
      'https://openweathermap.org/img/wn/' + icon + '.png'
    document.querySelector('.description').innerText = description
    document.querySelector('.temp').innerText = temp + '°C'
    document.querySelector('.humidity').innerText =
      'Humidity: ' + humidity + '%'
    document.querySelector('.wind').innerText = 'Wind speed: ' + speed + ' km/h'
    document.querySelector('.weather').classList.remove('loading')
    document.body.style.backgroundImage =
      "url('https://source.unsplash.com/1600x900/?" + name + "')"
  },
  search: function () {
    this.fetchWeather(document.querySelector('.search-bar').value);
  }
}

document.querySelector('.search button').addEventListener('click', function () {
  weather.search();
})

document.querySelector('.search-bar').addEventListener('keyup', function (event) {
    if (event.key == 'Enter') {
      weather.search()
    }
  });

weather.fetchWeather('Canberra');

function updateCurrentTime() {
  // Create a new Date object
  var now = new Date()

  // Get the current time components
  var hours = now.getHours()
  var minutes = now.getMinutes()
  var seconds = now.getSeconds()

  // Format the time to have leading zeros if needed
  hours = hours < 10 ? '0' + hours : hours
  minutes = minutes < 10 ? '0' + minutes : minutes
  seconds = seconds < 10 ? '0' + seconds : seconds

  // Display the current time in the 'currentTime' element
  document.getElementById('currentTime').textContent =
    hours + ':' + minutes + ':' + seconds
}

// Update the current time every second
setInterval(updateCurrentTime, 1000)

// Initial call to display the current time immediately
updateCurrentTime()

async function insert_past_data() {
  try {
    const response = await fetch('get_past_data.php')
    if (!response.ok) {
      throw new Error('Network response was not ok')
    }
    const data = await response.json();
    console.log(data);

    const divs = document.querySelectorAll('.past-data div');

    if (data.length > 0) {
      divs.forEach((div, i) => {
        div.innerHTML = `
        <p style = 'text-align:center'>Date: ${data[i].timestamp}</p>
        <p><img src="http://openweathermap.org/img/wn/02d@2x.png", height="30px", width="30px">Temperature: ${data[i].temperature}°C </p>
        <p><img src="https://cdn.iconscout.com/icon/free/png-512/free-humidity-1423995-1204211.png?f=webp&w=256", height="30px", width="30">Humidity: ${data[i].humidity}%</p>
        <p><img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/wind-speed-2295713-1939049.png?f=webp", height="30px", width="30">Wind_speed: ${data[i].speed}%</p>
        `;
      });
    } else {
      divs.forEach((div) => {
          div.innerHTML =
            '<h1 style = "padding-top: 30px; text-align: center">No data available</h1>'
      });
    }
  } catch (error) {
    console.error('Error fetching or parsing data:', error);
  }
}

insert_past_data()