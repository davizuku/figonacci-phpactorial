FROM golang:1.14

RUN go get github.com/cespare/reflex

# make the go module cache folder writable by all users otherwise linux users will not be able to write to it
RUN mkdir -p /go/pkg/mod/cache && chmod a+rw -R /go/pkg/mod/

COPY reflex.conf /

ENTRYPOINT ["reflex", "-c", "/reflex.conf"]
