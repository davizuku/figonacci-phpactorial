import sys
import os
import pandas as pd
import matplotlib.pyplot as plt

if len(sys.argv) < 2:
    print("Usage: " + os.path.basename(__file__) + " <filename> <method>")
    print("Given: " + " ".join(sys.argv))
    exit(1)

filename = sys.argv[1]
method = sys.argv[2] if len(sys.argv) == 3 else 'fibFac'

data = pd.read_csv('/data/' + filename + '.csv')

# FibFac process
ff = data[data['method'] == method]
ff.drop(columns=['method', 'value'], inplace=True)
ff = ff.groupby(['architecture', 'param']).mean()
ff = ff.reset_index()

fig, ax = plt.subplots()
for arch, df in ff.groupby('architecture'):
    ax.plot(df.param, df.time, marker='o', linestyle='dotted', lw=2, ms=3, label=arch)
ax.set_title("Benchmark comparison")
legend = ax.legend(bbox_to_anchor=(1, 1))
ax.grid('on')
plt.savefig('/data/' + filename + '.png', bbox_extra_artists=(legend,), bbox_inches='tight')
