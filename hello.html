<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            padding: 20px;
        }

        .calculator {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .display {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: right;
            border: 1px solid rgba(255, 255, 255, 0.1);
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .previous-operand {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.7);
            min-height: 27px;
            word-wrap: break-word;
            word-break: break-all;
        }

        .current-operand {
            font-size: 2.5rem;
            color: white;
            font-weight: bold;
            word-wrap: break-word;
            word-break: break-all;
        }

        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        button {
            border: none;
            padding: 20px;
            font-size: 1.3rem;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 600;
            color: white;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 70px;
        }

        button:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        button:active {
            transform: translateY(1px);
        }

        .operator {
            background: rgba(255, 107, 107, 0.2);
            color: #ff6b6b;
        }

        .equals {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            grid-column: span 2;
        }

        .clear {
            background: rgba(255, 159, 67, 0.2);
            color: #ff9f43;
        }

        .number {
            background: rgba(255, 255, 255, 0.05);
        }

        .zero {
            grid-column: span 2;
        }

        .calculator-title {
            text-align: center;
            color: white;
            margin-bottom: 20px;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .calculator-title i {
            color: #4facfe;
        }

        .history {
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 15px;
            color: white;
            max-height: 150px;
            overflow-y: auto;
        }

        .history h3 {
            margin-bottom: 10px;
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .history-item {
            padding: 5px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
        }

        .history-item:last-child {
            border-bottom: none;
        }

        @media (max-width: 480px) {
            .calculator {
                padding: 20px;
            }

            button {
                padding: 15px;
                font-size: 1.2rem;
                min-height: 60px;
            }

            .current-operand {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
<div class="calculator">
    <div class="calculator-title">
        <i class="fas fa-calculator"></i>
        Калькулятор
    </div>

    <div class="display">
        <div class="previous-operand" id="previous-operand"></div>
        <div class="current-operand" id="current-operand">0</div>
    </div>

    <div class="buttons">
        <button class="clear operator" data-action="clear">C</button>
        <button class="operator" data-action="delete">DEL</button>
        <button class="operator" data-action="divide">÷</button>
        <button class="operator" data-action="multiply">×</button>

        <button class="number" data-number="7">7</button>
        <button class="number" data-number="8">8</button>
        <button class="number" data-number="9">9</button>
        <button class="operator" data-action="subtract">-</button>

        <button class="number" data-number="4">4</button>
        <button class="number" data-number="5">5</button>
        <button class="number" data-number="6">6</button>
        <button class="operator" data-action="add">+</button>

        <button class="number" data-number="1">1</button>
        <button class="number" data-number="2">2</button>
        <button class="number" data-number="3">3</button>
        <button class="operator" data-action="percentage">%</button>

        <button class="number zero" data-number="0">0</button>
        <button class="number" data-action="decimal">.</button>
        <button class="equals" data-action="equals">=</button>
    </div>

    <div class="history">
        <h3><i class="fas fa-history"></i> История вычислений</h3>
        <div id="history-list"></div>
    </div>
</div>

<script>
    class Calculator {
        constructor(previousOperandElement, currentOperandElement, historyElement) {
            this.previousOperandElement = previousOperandElement;
            this.currentOperandElement = currentOperandElement;
            this.historyElement = historyElement;
            this.history = [];
            this.clear();
        }

        clear() {
            this.currentOperand = '0';
            this.previousOperand = '';
            this.operation = undefined;
            this.shouldResetScreen = false;
        }

        delete() {
            if (this.currentOperand === '0' || this.currentOperand.length === 1) {
                this.currentOperand = '0';
            } else {
                this.currentOperand = this.currentOperand.toString().slice(0, -1);
            }
        }

        appendNumber(number) {
            if (this.shouldResetScreen) {
                this.currentOperand = '';
                this.shouldResetScreen = false;
            }

            if (number === '.' && this.currentOperand.includes('.')) return;

            if (this.currentOperand === '0' && number !== '.') {
                this.currentOperand = number;
            } else {
                this.currentOperand = this.currentOperand.toString() + number.toString();
            }
        }

        chooseOperation(operation) {
            if (this.currentOperand === '0' && operation !== 'percentage') return;

            if (this.previousOperand !== '') {
                this.compute();
            }

            this.operation = operation;
            this.previousOperand = this.currentOperand;
            this.currentOperand = '0';
        }

        compute() {
            let computation;
            const prev = parseFloat(this.previousOperand);
            const current = parseFloat(this.currentOperand);

            if (isNaN(prev) || isNaN(current)) return;

            switch (this.operation) {
                case 'add':
                    computation = prev + current;
                    break;
                case 'subtract':
                    computation = prev - current;
                    break;
                case 'multiply':
                    computation = prev * current;
                    break;
                case 'divide':
                    if (current === 0) {
                        alert("Ошибка: деление на ноль!");
                        return;
                    }
                    computation = prev / current;
                    break;
                case 'percentage':
                    computation = prev * (current / 100);
                    break;
                default:
                    return;
            }

            // Сохраняем в историю
            const operationSymbols = {
                'add': '+',
                'subtract': '-',
                'multiply': '×',
                'divide': '÷',
                'percentage': '%'
            };

            const historyItem = {
                expression: `${prev} ${operationSymbols[this.operation]} ${current}`,
                result: computation.toFixed(8).replace(/\.?0+$/, '')
            };

            this.history.unshift(historyItem);
            if (this.history.length > 5) {
                this.history.pop();
            }
            this.updateHistory();

            this.currentOperand = computation.toString();
            this.operation = undefined;
            this.previousOperand = '';
            this.shouldResetScreen = true;
        }

        updateHistory() {
            this.historyElement.innerHTML = '';
            this.history.forEach(item => {
                const div = document.createElement('div');
                div.classList.add('history-item');
                div.innerHTML = `
                        <div>${item.expression} =</div>
                        <div style="color: #4facfe; font-weight: bold;">${item.result}</div>
                    `;
                this.historyElement.appendChild(div);
            });
        }

        getDisplayNumber(number) {
            const stringNumber = number.toString();
            const integerDigits = parseFloat(stringNumber.split('.')[0]);
            const decimalDigits = stringNumber.split('.')[1];

            let integerDisplay;

            if (isNaN(integerDigits)) {
                integerDisplay = '';
            } else {
                integerDisplay = integerDigits.toLocaleString('ru', {
                    maximumFractionDigits: 0
                });
            }

            if (decimalDigits != null) {
                return `${integerDisplay}.${decimalDigits}`;
            } else {
                return integerDisplay;
            }
        }

        updateDisplay() {
            this.currentOperandElement.innerText = this.getDisplayNumber(this.currentOperand);

            if (this.operation != null) {
                const operationSymbols = {
                    'add': '+',
                    'subtract': '-',
                    'multiply': '×',
                    'divide': '÷',
                    'percentage': '%'
                };
                this.previousOperandElement.innerText =
                    `${this.getDisplayNumber(this.previousOperand)} ${operationSymbols[this.operation]}`;
            } else {
                this.previousOperandElement.innerText = '';
            }
        }
    }

    // Инициализация калькулятора
    const previousOperandElement = document.getElementById('previous-operand');
    const currentOperandElement = document.getElementById('current-operand');
    const historyElement = document.getElementById('history-list');
    const calculator = new Calculator(previousOperandElement, currentOperandElement, historyElement);

    // Обработчики событий для кнопок
    document.querySelectorAll('[data-number]').forEach(button => {
        button.addEventListener('click', () => {
            calculator.appendNumber(button.getAttribute('data-number'));
            calculator.updateDisplay();
        });
    });

    document.querySelectorAll('[data-action]').forEach(button => {
        button.addEventListener('click', () => {
            const action = button.getAttribute('data-action');

            switch(action) {
                case 'clear':
                    calculator.clear();
                    break;
                case 'delete':
                    calculator.delete();
                    break;
                case 'equals':
                    calculator.compute();
                    break;
                case 'decimal':
                    calculator.appendNumber('.');
                    break;
                default:
                    calculator.chooseOperation(action);
                    break;
            }

            calculator.updateDisplay();
        });
    });

    // Поддержка клавиатуры
    document.addEventListener('keydown', event => {
        if (event.key >= 0 && event.key <= 9) {
            calculator.appendNumber(event.key);
            calculator.updateDisplay();
        }

        if (event.key === '.') {
            calculator.appendNumber('.');
            calculator.updateDisplay();
        }

        if (event.key === '+' || event.key === '-') {
            calculator.chooseOperation(event.key === '+' ? 'add' : 'subtract');
            calculator.updateDisplay();
        }

        if (event.key === '*' || event.key === 'x') {
            calculator.chooseOperation('multiply');
            calculator.updateDisplay();
        }

        if (event.key === '/') {
            calculator.chooseOperation('divide');
            calculator.updateDisplay();
        }

        if (event.key === 'Enter' || event.key === '=') {
            event.preventDefault();
            calculator.compute();
            calculator.updateDisplay();
        }

        if (event.key === 'Backspace') {
            calculator.delete();
            calculator.updateDisplay();
        }

        if (event.key === 'Escape') {
            calculator.clear();
            calculator.updateDisplay();
        }

        if (event.key === '%') {
            calculator.chooseOperation('percentage');
            calculator.updateDisplay();
        }
    });

    // Анимация при нажатии кнопок
    document.querySelectorAll('button').forEach(button => {
        button.addEventListener('mousedown', () => {
            button.style.transform = 'translateY(1px)';
        });

        button.addEventListener('mouseup', () => {
            button.style.transform = 'translateY(-3px)';
        });

        button.addEventListener('mouseleave', () => {
            button.style.transform = 'translateY(0)';
        });
    });
</script>
</body>
</html>
