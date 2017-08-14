<template>
    <div id="app">
        <div class="content-holder">
            <h2>Step 2</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ROI Calculator</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>tattoo removal</td>
                        <td>44 000</td>
                    </tr>
                    <tr>
                        <td>laser tattoo removal</td>
                        <td>1600</td>
                    </tr>
                    <tr>
                        <td>tattoo removal laser</td>
                        <td>50</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="total">Total</span>45650</td>
                    </tr>
                </tbody>
            </table>
            <form action="#" class="calculate-form">
                <fieldset>
                    <label for="conversion-rate">Conversion Rate</label>
                    <input type="number" id="conversion-rate" placeholder="4.0">
                    <label for="cpc">CPC</label>
                    <div class="currency-box"><input type="number" id="cpc" placeholder="8.50"></div>
                    <label for="for-client">Revenue For Client</label>
                    <div class="currency-box"><input type="number" id="for-client" placeholder="2 000"></div>
                    <div class="submit-row">
                        <input type="submit" value="Calculate" class="btn yellow">
                    </div>
                </fieldset>
            </form>
            <div class="calculate-text">
                <p>Based on the search demand and inputted metrics, you can expect a 177% return on investment from your ClientFlo Adwords campaign. This means for every $1 you invest, you should expect $1.77 in revenue.</p>
            </div>
        </div>
    </div>
</template>