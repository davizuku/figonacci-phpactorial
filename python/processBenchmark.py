import pandas as pd
import matplotlib.pyplot as plt

data = pd.read_csv('/data/example.csv')

# FibFac process
ff = data[data['method'] == 'fibFac']
ff.drop(columns=['method', 'value'], inplace=True)
ff = ff.groupby(['architecture', 'param']).mean()
ff = ff.reset_index()

fig, ax = plt.subplots()
for arch, df in ff.groupby('architecture'):
    ax.plot(df.param, df.time, marker='o', linestyle='dotted', lw=2, ms=5, label=arch)
ax.set_title("Benchmark comparison")
legend = ax.legend(bbox_to_anchor=(1, 1))
ax.grid('on')
plt.savefig('/data/example.png', bbox_extra_artists=(legend,), bbox_inches='tight')
