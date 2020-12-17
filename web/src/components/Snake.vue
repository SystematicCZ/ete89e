<template>
  <div>
    <div class="d-flex justify-content-between mb-2">
      <div>
        Score: {{ score }}
      </div>
      <div>
        Best: {{ maxScore }}
      </div>
    </div>
    <canvas
      ref="world"
      :width="width"
      :height="height"
      class="d-block mx-auto"
    />
  </div>
</template>
<script>
const gameWidth = 20;
const gameHeight = 20;

export default {
  props: {
    width: { type: Number, default: 400 },
    height: { type: Number, default: 400 },
  },
  data() {
    return {
      score: 0,
      maxScore: 0,
      world: {
        plane: null,
        width: Math.floor(this.width / gameWidth),
        height: Math.floor(this.height / gameHeight),
      },
      food: {
        x: 0,
        y: 0,
      },
      snake: {
        x: 0,
        y: 0,
        baseLength: 3,
        length: 3,
        body: [],
      },
      move: {
        x: 0,
        y: 0,
        last: null,
      },
    };
  },
  created() {
    window.addEventListener('keydown', this.onKeyPush);
  },
  destroyed() {
    window.removeEventListener('keydown', this.onKeyPush);
  },
  mounted() {
    this.init();
    setInterval(this.tick, 70);
  },
  methods: {
    tick() {
      this.snake.x += this.move.x;
      this.snake.y += this.move.y;

      this.adjust();
      this.fillCanvas();
      this.drawSnake();
      this.drawFood();

      this.snake.body.push({ x: this.snake.x, y: this.snake.y });

      if (this.snake.body.length > this.snake.length) {
        this.snake.body.splice(0, (this.snake.body.length - this.snake.length));
      }

      if (this.snake.x === this.food.x && this.snake.y === this.food.y) {
        this.snake.length += 1;
        this.score += 1;
        this.placeFood();
      }
    },
    adjust() {
      if (this.snake.x >= gameWidth) {
        this.snake.x = 0;
      }
      if (this.snake.x < 0) {
        this.snake.x = gameWidth - 1;
      }
      if (this.snake.y >= gameHeight) {
        this.snake.y = 0;
      }
      if (this.snake.y < 0) {
        this.snake.y = gameHeight - 1;
      }
    },

    fillCanvas() {
      this.world.plane.fillStyle = 'black';
      this.world.plane.fillRect(0, 0, this.width, this.height);
    },

    drawSnake() {
      this.world.plane.fillStyle = 'white';
      this.snake.body.forEach((part) => {
        this.world.plane.fillRect(part.x * this.world.width, part.y * this.world.height, this.world.width - 3, this.world.height - 3);
        if (part.x === this.snake.x && part.y === this.snake.y) {
          this.snake.length = this.snake.baseLength;
          if (this.score > this.maxScore) {
            this.maxScore = this.score;
          }
          this.score = 0;
        }
      });
    },
    drawFood() {
      this.world.plane.fillStyle = 'red';
      this.world.plane.fillRect(this.food.x * this.world.width, this.food.y * this.world.height, this.world.width - 3, this.world.height - 3);
    },
    placeFood() {
      this.food.x = Math.floor(Math.random() * (gameWidth - 1));
      this.food.y = Math.floor(Math.random() * (gameHeight - 1));
    },
    init() {
      this.world.plane = this.$refs.world.getContext('2d');
      this.snake.x = Math.floor(gameWidth / 2);
      this.snake.y = Math.floor(gameHeight / 2);
      this.snake.body.push({ x: this.snake.x - 1, y: this.snake.y });
      this.snake.body.push({ x: this.snake.x, y: this.snake.y });

      this.move.x = 1;
      this.move.last = 'ArrowRight';

      this.placeFood();
    },
    onKeyPush(event) {
      switch (event.code) {
        case 'ArrowLeft':
          if (this.move.last === 'ArrowRight') {
            break;
          }
          this.move.x = -1;
          this.move.y = 0;
          this.move.last = 'ArrowLeft';
          break;
        case 'ArrowUp':
          if (this.move.last === 'ArrowDown') {
            break;
          }
          this.move.x = 0;
          this.move.y = -1;
          this.move.last = 'ArrowUp';
          break;
        case 'ArrowRight':
          if (this.move.last === 'ArrowLeft') {
            break;
          }
          this.move.x = 1;
          this.move.y = 0;
          this.move.last = 'ArrowRight';
          break;
        case 'ArrowDown':
          if (this.move.last === 'ArrowUp') {
            break;
          }
          this.move.x = 0;
          this.move.y = 1;
          this.move.last = 'ArrowDown';
          break;
      }
    },
  },
};
</script>
