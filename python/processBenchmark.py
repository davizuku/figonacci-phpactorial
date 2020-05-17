import sys
import os
import pandas as pd
import matplotlib.pyplot as plt

if len(sys.argv) != 2:
    print("Usage: " + os.path.basename(__file__) + " <filename> <method>")
    print("Given: " + " ".join(sys.argv))
    exit(1)

filename = sys.argv[1]

data = pd.read_csv('/data/' + filename + '.csv')

ff = data.drop(columns=['method', 'value'])
ff = ff.groupby(['architecture', 'param']).mean()
ff = ff.reset_index()

fig, ax = plt.subplots()
markers = "++xxDDo."
i = 0
for arch, df in ff.groupby('architecture'):
    ax.plot(df.param, df.time, marker=markers[i],
            linestyle='dotted', lw=1, ms=6, label=arch)
    i += 1
ax.set_title("Benchmark " + filename)
plt.ylabel("Execution time (s)")
if "textlen" in filename.lower():
    plt.xlabel("Problem size (2^x)")
else:
    plt.xlabel("Problem size")
legend = ax.legend(bbox_to_anchor=(1, 1))
ax.grid('on')
plt.savefig(
    '/data/' + filename + '.png',
    bbox_extra_artists=(legend,),
    bbox_inches='tight'
)
