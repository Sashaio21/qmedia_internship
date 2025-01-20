const swiper = new Swiper('.swiper-container', {
    loop: false, // Бесконечный цикл слайдов
    slidesPerView: 1, // Показывать один слайд
    spaceBetween: 0, // Отступы между слайдами
    autoplay: {
      delay: 3000, // Время между сменой слайдов (в миллисекундах)
      disableOnInteraction: false, // Автопрокрутка не останавливается при взаимодействии с слайдером
    },
  });
  